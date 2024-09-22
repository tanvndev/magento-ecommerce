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

    public function create()
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

        if (! $paymentMethod) {
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

        if (! $shippingMethod) {
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

        if (! $cart) {
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

    public function update(string $id)
    {
        return $this->executeInTransaction(function () use ($id) {}, __('messages.order.error.payment'));
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
            'order_id' => $order->id,
            'payment_method_id' => $order->payment_method_id,
            'payment_detail' => $payload['payment_detail'],
            'method_name' => $order->payment_method->name,
        ];
    }

    private function sendMailUpdatePayment(Order $order)
    {
        // $mail = new OrderMail($order);
        // $mail->send();
    }

    public function getOrder(string $orderCode)
    {
        $order = $this->orderRepository->findByWhere(
            ['code' => $orderCode],
            ['*'],
            ['order_items']
        );

        return $order;
    }
}
