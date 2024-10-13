<?php

namespace App\Services\Order;

use App\Models\Order;
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
use Illuminate\Support\Facades\Cache;

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

    // public function paginate()
    // {
    //     return $this->orderRepository->paginate();
    // }

<<<<<<< HEAD
    public function create()
=======
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
                if ( ! $this->checkUpdateStatus($request, $order)) {
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
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
    {
        return $this->executeInTransaction(function () {
            $request = request();

            $order = $this->createOrder($request);

            return $order;
        }, __('messages.order.error.create'));
    }

    private function createOrder($request)
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

        return $order;
    }

    private function prepareOrderPayload($request, $userId)
    {
        return array_merge($request->except('_token'), [
            'user_id'    => $userId,
            'code'       => generateOrderCode(),
            'ordered_at' => now(),
        ]);
    }

    private function getPaymentMethod($paymentMethodId)
    {
        $paymentMethod = $this->paymentMethodRepository->findByWhere([
            'id'      => $paymentMethodId,
            'publish' => 1,
        ]);

        if ( ! $paymentMethod) {
            throw new Exception('Payment method not found.');
        }

        return $paymentMethod;
    }

    private function getShippingMethod($shippingMethodId)
    {
        $shippingMethod = $this->shippingMethodRepository->findByWhere([
            'id'      => $shippingMethodId,
            'publish' => 1,
        ]);

        if ( ! $shippingMethod) {
            throw new Exception('Shipping method not found.');
        }

        return $shippingMethod;
    }

    private function getCartItems($userId)
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

        if ( ! $cart) {
            throw new Exception('Cart not found.');
        }

        return $cart->cart_items;
    }

    private function getAdditionalDetails($paymentMethod, $shippingMethod, &$payload)
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

    private function applyVoucher(&$payload)
    {
        $voucher = $this->voucherRepository->findByWhere([
            'id'      => $payload['voucher_id'],
            'publish' => 1,
        ]);

        if ( ! $voucher) {
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
    }

    private function createOrderItems($order, $cartItems)
    {
        $payloadOrderItem = $this->formatPayloadOrderItem($cartItems ?? [], $order->id);
        $order->order_items()->createMany($payloadOrderItem);
    }

    private function formatPayloadOrderItem($cartItem, $orderId)
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

    private function calculateFinalPrice($payload)
    {
        $totalPrice = floatval($payload['total_price'] ?? 0);
        $shippingFee = floatval($payload['shipping_fee'] ?? 0);
        $discount = floatval($payload['discount'] ?? 0);

        $finalPrice = $totalPrice + $shippingFee - $discount;

        return $finalPrice;
    }

    private function calculateShippingFee($shippingMethod)
    {
        return $shippingMethod->base_cost;
    }

    private function calculateTotalPrice($cartItems)
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

    private function getEffectivePrice($productVariant, $returnOriginalPrice = true)
    {
        if ($this->isSalePriceValid($productVariant)) {
            return $productVariant->sale_price;
        }

        return $returnOriginalPrice ? $productVariant->price : null;
    }

    private function isSalePriceValid($productVariant)
    {
        if ( ! $productVariant->sale_price || ! $productVariant->price) {
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

    public function update(string $id)
    {
        return $this->executeInTransaction(function () {}, __('messages.order.error.payment'));
    }

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

    private function formatPayloadOrderPaymentable(Order $order, array $payload)
    {

        return [
            'order_id'          => $order->id,
            'payment_method_id' => $order->payment_method_id,
            'payment_detail'    => $payload['payment_detail'],
            'method_name'       => $order->payment_method->name,
        ];
    }

    private function sendMailUpdatePayment(Order $order)
    {
        // $mail = new OrderMail($order);
        // $mail->send();
    }

    public function getOrder(string $orderCode)
    {
        $condition = [
            'code'    => $orderCode,
            'user_id' => auth()->check() ? auth()->user()->id : null,
        ];

        $order = $this->orderRepository->findByWhere(
            $condition,
            ['*'],
            ['order_items']
        );

        return $order;
    }

    public function getOrderByUser()
    {
        if ( ! auth()->check()) {
            return [];
        }

        $request = request();
        $userId = auth()->user()->id;

        $conditionWhere = [
            'user_id' => $userId,
        ];
        if ($request->order_status == Order::PAYMENT_STATUS_UNPAID) {
            $conditionWhere['payment_status'] = Order::PAYMENT_STATUS_UNPAID;
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

        $cacheKey = 'orders_' . md5(json_encode($condition)) . '_page_' . $request->page ?? 5 . '_user_id_' . $userId;

        $data = Cache::remember($cacheKey, 600, function () use ($condition) { // 600 seconds
            return $this->orderRepository->pagination(
                ['*'],
                $condition,
                5,
                [],
                [],
                ['order_items'],
            );
        });

        return $data;
    }
}
