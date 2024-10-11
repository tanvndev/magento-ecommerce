<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Voucher;
use App\Repositories\Interfaces\Cart\CartRepositoryInterface;
use App\Repositories\Interfaces\Order\OrderRepositoryInterface;
use App\Repositories\Interfaces\PaymentMethod\PaymentMethodRepositoryInterface;
use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;
use App\Repositories\Interfaces\ShippingMethod\ShippingMethodRepositoryInterface;
use App\Repositories\Interfaces\Voucher\VoucherRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Order\OrderServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class OrderService extends BaseService implements OrderServiceInterface
{
    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
        protected ProductVariantRepositoryInterface $productVariantRepository,
        protected CartRepositoryInterface $cartRepository,
        protected PaymentMethodRepositoryInterface $paymentMethodRepository,
        protected ShippingMethodRepositoryInterface $shippingMethodRepository,
        protected VoucherRepositoryInterface $voucherRepository
    ) {}

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    /**
     * Get all orders with pagination
     *
     * @queryParam search string Search order by code. Example: T123456
     * @queryParam page_size int Number of orders to return per page. Example: 12
     * @queryParam page int Page number to return. Example: 1
     * @queryParam sort string Sort order by column. Example: created_at|DESC
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate()
    {
        $request = request();

        $condition = [
            'search'       => addslashes($request->search),
            'searchFields' => ['code'],
        ];

        $pageSize = $request->pageSize;

        $data = $this->orderRepository->pagination(['*'], $condition, $pageSize);

        return $data;
    }

    /**
     * Get an order by its code.
     *
     * @param  string  $orderCode  The order code.
     * @return \App\Models\Order The order.
     */
    public function getOrder(string $orderCode): Order
    {
        $condition = [
            'code'    => $orderCode,
        ];

        $order = $this->orderRepository->findByWhere(
            $condition,
            ['*'],
            ['order_items']
        );

        return $order;
    }

    /**
     * Update an order
     */
    public function update(string $id): array
    {
        return $this->executeInTransaction(function () use ($id) {
            $request = request();
            $payload = $this->handlePayloadUpdate($request);

            $order = $this->orderRepository->findById($id);

            if (
                $request->has('order_status')
                && $request->has('payment_status')
                && $request->has('delivery_status')
            ) {
                if (! $this->checkUpdateStatus($request, $order)) {
                    return errorResponse(__('messages.order.error.invalid'));
                }
            }

            $order->update($payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    /**
     * Handle the payload of the update request.
     *
     * This method takes the request and returns an array of the payload that can be used to update the order.
     * The payload is filtered to only include the fields that are required for the update.
     * The fields that are included in the payload are:
     *  - ordered_at if the order status is being updated
     *  - paid_at if the payment status is being updated
     *  - delivered_at if the delivery status is being updated
     *
     * @param  \Illuminate\Http\Request  $request
     */
    private function handlePayloadUpdate($request): array
    {
        $payload = $request->except('_token', '_method');
        $now = now();

        if ($request->has('order_status')) {
            $payload['ordered_at'] = $now;
        }

        if ($request->has('payment_status')) {
            $payload['paid_at'] = $now;
        }

        if ($request->has('delivery_status')) {
            $payload['delivered_at'] = $now;
        }

        return $payload;
    }

    /**
     * Check if the order can be updated to the given status.
     *
     * If the order status is to be updated to completed, the payment status must be paid and the delivery status must be delivered.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function checkUpdateStatus($request, Order $order): bool
    {
        if ($request->order_status == Order::ORDER_STATUS_COMPLETED) {
            if (
                $order->payment_status != Order::PAYMENT_STATUS_PAID
                || $order->delivery_status != Order::DELYVERY_STATUS_DELIVERED
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Create a new order in the database.
     *
     * @return \App\Models\Order|null
     */
    public function create(): mixed
    {
        return $this->executeInTransaction(function () {
            $request = request();

            $order = $this->createOrder($request);

            return $order;
        }, __('messages.order.error.create'));
    }

    /**
     * Create a new order in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    private function createOrder($request): Order
    {
        $userId = auth()->user()->id;
        $payload = $this->prepareOrderPayload($request, $userId);

        $paymentMethod = $this->getPaymentMethod($payload['payment_method_id']);
        $shippingMethod = $this->getShippingMethod($payload['shipping_method_id']);
        $cartItems = $this->getCartItems($userId);

        $payload['total_price'] = $this->calculateTotalPrice($cartItems);
        $payload['additional_details'] = $this->getAdditionalDetails($paymentMethod, $shippingMethod, $payload);

        if (isset($payload['voucher_id'])) {
            $this->applyVoucher($payload);
        }

        $payload['shipping_fee'] = $this->calculateShippingFee($shippingMethod);
        $payload['final_price'] = $this->calculateFinalPrice($payload);

        $order = $this->orderRepository->create($payload);
        $this->createOrderItems($order, $cartItems);

        $this->decreaseStockProductVariants($cartItems);

        return $order;
    }

    /**
     * Decrease stock of product variants when creating an order.
     *
     * This method loops through the cart items and decrements the stock of each product variant by the quantity of the cart item.
     * It also sets the is_used flag of the product variant to true.
     *
     * @param  \Illuminate\Support\Collection  $cartItems
     */
    private function decreaseStockProductVariants(Collection $cartItems): void
    {
        foreach ($cartItems as $cartItem) {
            $productVariant = $cartItem->product_variant->lockForUpdate()->first();
            $quantity = $cartItem->quantity;

            $productVariant->update(
                [
                    'stock'   => $productVariant->stock - $quantity,
                    'is_used' => true,
                ]
            );
        }
    }

    /**
     * Prepare order payload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userId
     */
    private function prepareOrderPayload($request, string $userId): array
    {
        return array_merge($request->except('_token'), [
            'user_id'    => $userId,
            'code'       => generateOrderCode(),
            'ordered_at' => now(),
        ]);
    }

    /**
     * Get a payment method by id.
     *
     * @return \App\Models\PaymentMethod
     *
     * @throws Exception
     */
    private function getPaymentMethod(int $paymentMethodId)
    {
        $paymentMethod = $this->paymentMethodRepository->findByWhere([
            'id'      => $paymentMethodId,
            'publish' => 1,
        ]);

        if (! $paymentMethod) {
            throw new Exception('Payment method not found.');
        }

        return $paymentMethod;
    }

    /**
     * Get a shipping method by id.
     *
     * @return \App\Models\ShippingMethod
     *
     * @throws Exception
     */
    private function getShippingMethod(int $shippingMethodId)
    {
        $shippingMethod = $this->shippingMethodRepository->findByWhere([
            'id'      => $shippingMethodId,
            'publish' => 1,
        ]);

        if (! $shippingMethod) {
            throw new Exception('Shipping method not found.');
        }

        return $shippingMethod;
    }

    /**
     * Get cart items by user id.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     *
     * @throws Exception
     */
    private function getCartItems(int $userId)
    {
        $relation = [
            [
                'cart_items' => function ($query) {
                    $query->where('is_selected', true);
                },
                'cart_items.product_variant' => function ($query) {
                    $query->whereHas('product', function ($q) {
                        $q->where('publish', 1);
                    });
                },
            ],
        ];

        $cart = $this->cartRepository->findByWhere(['user_id' => $userId], ['*'], $relation);

        if (! $cart) {
            throw new Exception('Cart not found.');
        }

        return $cart->cart_items;
    }

    /**
     * Get additional details from payment method and shipping method to store in order.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @param  \App\Models\ShippingMethod  $shippingMethod
     * @return array
     */
    private function getAdditionalDetails($paymentMethod, $shippingMethod, array &$payload)
    {
        return [
            'payment_method' => [
                'id'   => $paymentMethod->id,
                'name' => $paymentMethod->name,
            ],
            'shipping_method' => [
                'id'        => $shippingMethod->id,
                'name'      => $shippingMethod->name,
                'base_cost' => $shippingMethod->base_cost,
            ],
        ];
    }

    /**
     * Apply voucher to order.
     *
     * @throws Exception
     */
    private function applyVoucher(array &$payload)
    {
        $voucher = $this->voucherRepository->findByWhere([
            'id'      => $payload['voucher_id'],
            'publish' => 1,
        ])->lockForUpdate()->first();

        if (! $voucher) {
            throw new Exception('Voucher not found.');
        }

        $payload['additional_details']['voucher'] = [
            'id'         => $voucher->id,
            'name'       => $voucher->name,
            'value_type' => $voucher->value_type,
            'value'      => $voucher->value,
        ];

        if ($voucher->value_type === Voucher::TYPE_PERCENT) {
            $payload['discount'] = min($payload['total_price'] * ($voucher->value / 100), $voucher->value_limit_amount);
        } elseif ($voucher->value_type === Voucher::TYPE_FIXED) {
            $payload['discount'] = $voucher->value;
        }

        $voucher->quantity -= 1;
        $voucher->save();
    }

    /**
     * Create order items from cart items.
     *
     * @param  \App\Models\Order  $order
     * @param  \Illuminate\Database\Eloquent\Collection  $cartItems
     */
    private function createOrderItems($order, $cartItems): void
    {
        $payloadOrderItem = $this->formatPayloadOrderItem($cartItems ?? [], $order->id);
        $order->order_items()->createMany($payloadOrderItem);
    }

    /**
     * Format payload for create order items
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $cartItem
     */
    private function formatPayloadOrderItem($cartItem, int $orderId): array
    {
        $payload = $cartItem->map(function ($item) use ($orderId) {
            $salePrice = $this->getEffectivePrice($item->product_variant, false);

            return [
                'order_id'             => $orderId,
                'uuid'                 => $item->product_variant->uuid,
                'product_variant_id'   => $item->product_variant_id,
                'product_variant_name' => $item->product_variant->name,
                'quantity'             => $item->quantity,
                'price'                => $item->product_variant->price,
                'sale_price'           => $salePrice != null ? floatval($salePrice) : null,
            ];
        })->toArray();

        return $payload;
    }

    /**
     * Calculate final price of an order.
     */
    private function calculateFinalPrice(array $payload): float
    {
        $totalPrice = floatval($payload['total_price'] ?? 0);
        $shippingFee = floatval($payload['shipping_fee'] ?? 0);
        $discount = floatval($payload['discount'] ?? 0);

        $finalPrice = $totalPrice + $shippingFee - $discount;

        return $finalPrice;
    }

    /**
     * Calculate shipping fee from shipping method.
     *
     * @param  \App\Models\ShippingMethod  $shippingMethod
     */
    private function calculateShippingFee($shippingMethod): float
    {
        return $shippingMethod->base_cost;
    }

    /**
     * Calculate total price of an order from cart items.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $cartItems
     */
    private function calculateTotalPrice($cartItems): float
    {
        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $productVariant = $item->product_variant;
            $quantity = $item->quantity;

            $price = $this->getEffectivePrice($productVariant);

            if ($price != null) {
                $totalPrice += $price * $quantity;
            }
        }

        return $totalPrice;
    }

    /**
     * Get the effective price of a product variant, taking into account the sale price
     * and discount time.
     *
     * If the sale price is valid, return the sale price. Otherwise, return the original
     * price if $returnOriginalPrice is true, or null if it is false.
     *
     * @param  \App\Models\ProductVariant  $productVariant
     */
    private function getEffectivePrice($productVariant, bool $returnOriginalPrice = true): ?float
    {
        if ($this->isSalePriceValid($productVariant)) {
            return $productVariant->sale_price;
        }

        return $returnOriginalPrice ? $productVariant->price : null;
    }

    /**
     * Determine if the sale price of a product variant is valid.
     *
     * A sale price is valid if it has a value and the product variant has a price.
     * If the product variant has a discount time,
     * the sale price is valid if the current time is between the start and end times
     * of the discount time.
     * If the product variant does not have a discount time,
     * the sale price is valid.
     *
     * @param  \App\Models\ProductVariant  $productVariant
     */
    private function isSalePriceValid($productVariant): bool
    {
        if (! $productVariant->sale_price || ! $productVariant->price) {
            return false;
        }

        if ($productVariant->is_discount_time) {
            if ($productVariant->sale_price_start_at && $productVariant->sale_price_end_at) {
                $now = now();
                $start = \Carbon\Carbon::parse($productVariant->sale_price_start_at);
                $end = \Carbon\Carbon::parse($productVariant->sale_price_end_at);

                if ($now > $start || $now < $end) {
                    return true;
                }
            }
        } else {
            return true;
        }

        return false;
    }

    /**
     * Update the payment of an order.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePayment(string $id, array $payload)
    {
        return $this->executeInTransaction(function () use ($id, $payload) {

            $payload['paid_at'] = now();

            $order = $this->orderRepository->save($id, $payload);

            $payloadOrderPaymentable = $this->formatPayloadOrderPaymentable($order, $payload);

            $order->order_paymentable()->create($payloadOrderPaymentable);

            return successResponse(__('messages.order.success.payment'));
        }, __('messages.order.error.payment'));
    }

    /**
     * Format the payload for OrderPaymentable model.
     */
    private function formatPayloadOrderPaymentable(Order $order, array $payload): array
    {

        return [
            'order_id'          => $order->id,
            'payment_method_id' => $order->payment_method_id,
            'payment_detail'    => $payload['payment_detail'],
            'method_name'       => $order->payment_method->name,
        ];
    }

    /**
     * Send mail to customer when update payment status of an order.
     */
    private function sendMailUpdatePayment(Order $order): void
    {
        // $mail = new OrderMail($order);
        // $mail->send();
    }

    /**
     * Get an order by its code and the current user's id.
     *
     * If the user is not logged in, only return the order if it exists.
     * If the user is logged in, only return the order if it exists and belongs to the user.
     */
    public function getOrderUserByCode(string $orderCode): ?Order
    {
        $condition = [
            'code'    => $orderCode,
            // 'user_id' => auth()->check() ? auth()->user()->id : null,
        ];

        $order = $this->orderRepository->findByWhere(
            $condition,
            ['*'],
            ['order_items']
        );

        return $order;
    }

    /**
     * Get all orders of the current user.
     *
     * If the user is not logged in, return an empty array.
     *
     * @return \App\Models\Order[]
     */
    public function getOrderByUser()
    {
        if (! auth()->check()) {
            return [];
        }

        $request = request();
        $userId = auth()->user()->id;

        $conditionWhere = [
            'user_id' => $userId,
        ];
        if ($request->order_status == Order::PAYMENT_STATUS_UNPAID) {
            $conditionWhere['payment_status'] = Order::PAYMENT_STATUS_UNPAID;
            $conditionWhere['payment_method_id'] = ['!=', PaymentMethod::COD_ID];
        }

        if (
            $request->has('order_status') &&
            $request->order_status != '' &&
            $request->order_status != 'all' &&
            $request->order_status != Order::PAYMENT_STATUS_UNPAID
        ) {
            $conditionWhere['order_status'] = $request->order_status;
        }

        $condition = [
            'search'       => addslashes($request->search),
            'searchFields' => ['code'],
            'where'        => $conditionWhere,
        ];

        return $this->orderRepository->pagination(
            ['*'],
            $condition,
            5,
            [],
            [],
            ['order_items'],
        );
    }

    public function updateStatusOrderToCompleted(string $id)
    {
        return $this->executeInTransaction(function () use ($id) {

            if (! auth()->check()) {
                return errorResponse(__('messages.order.error.status'));
            }

            $payload = request()->except('_token', '_method');
            $payload['order_status'] = Order::ORDER_STATUS_COMPLETED;
            $payload['ordered_at'] = now();

            $order = $this->orderRepository->findByWhere(
                [
                    'id'      => $id,
                    'user_id' => auth()->user()->id,
                ]
            );

            if ($order->payment_status != Order::PAYMENT_STATUS_PAID) {
                return errorResponse(__('messages.order.error.status'));
            }

            $order->update($payload);

            return successResponse(__('messages.order.success.status'));
        }, __('messages.order.error.status'));
    }

    public function updateStatusOrderToCancelled(string $id)
    {
        return $this->executeInTransaction(function () use ($id) {

            if (! auth()->check()) {
                return errorResponse(__('messages.order.error.status'));
            }

            $payload = request()->except('_token', '_method');
            $payload['order_status'] = Order::ORDER_STATUS_CANCELED;
            $payload['ordered_at'] = now();

            $order = $this->orderRepository->findByWhere(
                [
                    'id'      => $id,
                    'user_id' => auth()->user()->id,
                ]
            );

            if (
                $order->delivery_status == Order::DELYVERY_STATUS_DELIVERING
                || $order->order_status == Order::ORDER_STATUS_DELIVERING
            ) {
                return errorResponse(__('messages.order.error.status'));
            }

            $order->update($payload);

            return successResponse(__('messages.order.success.status'));
        }, __('messages.order.error.status'));
    }
}
