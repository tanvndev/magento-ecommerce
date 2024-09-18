<?php

namespace App\Services\Order;

use App\Models\Voucher;
use App\Repositories\Interfaces\Cart\CartRepositoryInterface;
use App\Repositories\Interfaces\Order\OrderRepositoryInterface;
use App\Repositories\Interfaces\PaymentMethod\PaymentMethodRepositoryInterface;
use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;
use App\Repositories\Interfaces\ShippingMethod\ShippingMethodRepositoryInterface;
use App\Repositories\Interfaces\Voucher\VoucherRepositoryInterface;
use App\Services\Interfaces\Order\OrderServiceInterface;
use App\Services\BaseService;

class OrderService extends BaseService implements OrderServiceInterface
{
    protected $orderRepository;

    protected $productVariantRepository;

    protected $cartRepository;

    protected $paymentMethodRepository;

    protected $shippingMethodRepository;

    protected $voucherRepository;



    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductVariantRepositoryInterface $productVariantRepository,
        CartRepositoryInterface $cartRepository,
        PaymentMethodRepositoryInterface $paymentMethodRepository,
        ShippingMethodRepositoryInterface $shippingMethodRepository,
        VoucherRepositoryInterface $voucherRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->cartRepository = $cartRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->shippingMethodRepository = $shippingMethodRepository;
        $this->voucherRepository = $voucherRepository;
    }

    // public function paginate()
    // {
    //     return $this->orderRepository->paginate();
    // }


    public function create()
    {
        return $this->executeInTransaction(function () {
            $request = request();

            $payload = $this->createOrder($request);

            dd($payload ?? 0);
        });
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

        dd(1);
        return $order;
    }

    private function prepareOrderPayload($request, $userId)
    {
        return array_merge($request->except('_token'), [
            'user_id' => $userId,
            'code' => generateOrderCode(),
            'ordered_at' => now(),
        ]);
    }

    private function getPaymentMethod($paymentMethodId)
    {
        $paymentMethod = $this->paymentMethodRepository->findByWhere([
            'id' => $paymentMethodId,
            'publish' => 1,
        ]);

        if (!$paymentMethod) {
            throw new \Exception('Payment method not found.');
        }

        return $paymentMethod;
    }

    private function getShippingMethod($shippingMethodId)
    {
        $shippingMethod = $this->shippingMethodRepository->findByWhere([
            'id' => $shippingMethodId,
            'publish' => 1,
        ]);

        if (!$shippingMethod) {
            throw new \Exception('Shipping method not found.');
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
                }
            ]
        ];

        $cart = $this->cartRepository->findByWhere(['user_id' => $userId], ['*'], $relation);

        if (!$cart) {
            throw new \Exception('Cart not found.');
        }

        return $cart->cart_items;
    }

    private function getAdditionalDetails($paymentMethod, $shippingMethod, &$payload)
    {
        return [
            'payment_method' => [
                'id' => $paymentMethod->id,
                'name' => $paymentMethod->name,
            ],
            'shipping_method' => [
                'id' => $shippingMethod->id,
                'name' => $shippingMethod->name,
                'base_cost' => $shippingMethod->base_cost,
            ],
        ];
    }

    private function applyVoucher(&$payload)
    {
        $voucher = $this->voucherRepository->findByWhere([
            'id' => $payload['voucher_id'],
            'publish' => 1,
        ]);

        if (!$voucher) {
            throw new \Exception('Voucher not found.');
        }

        $payload['additional_details']['voucher'] = [
            'id' => $voucher->id,
            'name' => $voucher->name,
            'value_type' => $voucher->value_type,
            'value' => $voucher->value,
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
                'order_id' => $orderId,
                'uuid' => $item->product_variant->uuid,
                'product_variant_id' => $item->product_variant_id,
                'product_variant_name' => $item->product_variant->name,
                'quantity' => $item->quantity,
                'price' => $item->product_variant->price,
                'sale_price' => $salePrice != null ? floatval($salePrice) : null
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
        if (!$productVariant->sale_price || !$productVariant->price) {
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


    public function update($id)
    {
        return $this->orderRepository->update($id);
    }

    public function order()
    {
        // DB::beginTransaction();
        // try {
        //     $payload = $this->handlePayloadOrder();

        //     $order = $this->orderRepository->create($payload);

        //     if ($order->id == null || empty($order->id)) {
        //         throw new \Exception('Error create order.');
        //     }
        //     $payload['id'] = $order->id;
        //     // Dong bo du lieu vao bang order_product
        //     $this->createOrderProduct($payload, $order);
        //     // Gui mail cho khach hang
        //     $this->sendMail($payload);
        //     DB::commit();
        //     return $payload;
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     echo $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        //     die;
        //     return [];
        // }
    }

    private function sendMail($order)
    {
        $to = $order['email'];
        $cc = env('MAIL_USERNAME');
        Mail::to($to)->cc($cc)->send(new OrderMail($order));
    }



    private function createOrderProduct($payload, $order)
    {
        $data = [];
        foreach ($payload['cart']['detail'] as $key => $cartItem) {
            // tach ra de lay product_id va uuid
            $ids = explode('_', $cartItem->id);

            $data[] = [
                'product_id' => $ids[0],
                'uuid' => $ids[1] ?? 0,
                'name' => $cartItem->name,
                'quantity' => $cartItem->qty,
                'price' => $cartItem->originalPrice,
                'price_sale' => $cartItem->price,
                'promotion' => json_encode($payload['promotion']),
                'option' => json_encode($cartItem->options)
            ];
        }

        $order->products()->sync($data);
    }


    public function cartPromotion($cartTotal)
    {
        $maxDiscount = 0;
        $selectedPromotion = null;
        $promotions = $this->promotionRepository->getPromtionByCartTotal(0);

        if (empty($promotions)) {
            return [];
        }

        foreach ($promotions as $promotion) {
            $discountInfo = $promotion->discount_infomation['info'];
            $amountFrom = $discountInfo['amountFrom'] ?? [];
            $amountTo = $discountInfo['amountTo'] ?? [];
            $amountValue = $discountInfo['amountValue'] ?? [];
            $amountType = $discountInfo['amountType'] ?? [];

            $length = min(count($amountFrom), count($amountTo), count($amountValue), count($amountType));

            for ($i = 0; $i < $length; $i++) {
                $currentAmountFrom = convertPrice($amountFrom[$i]);
                $currentAmountTo = convertPrice($amountTo[$i]);
                $currentAmountValue = convertPrice($amountValue[$i]);
                $currentAmountType = $amountType[$i];

                if (($cartTotal > $currentAmountFrom && $cartTotal <= $currentAmountTo) || $cartTotal > $currentAmountTo) {
                    if ($currentAmountType == 'cast') {
                        $discount = $currentAmountValue;
                    } elseif ($currentAmountType == 'percent') {
                        $discount = ($currentAmountValue / 100) * $cartTotal;
                    } else {
                        continue;
                    }

                    // Lay ra discount co duoc giam gia nhieu nhat
                    if ($discount > $maxDiscount) {
                        $maxDiscount = $discount;
                        $selectedPromotion = $promotion;
                    }
                }
            }
        }

        return [
            'discount' => $maxDiscount,
            'promotion' => $selectedPromotion,
        ];
    }

    private function handlePayloadOrder()
    {
        $carts = $this->getCart();
        $cartPromotion = $this->cartPromotion($carts->total);

        // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
        $payload = request()->except('_token');
        $payload['code'] = $this->generateOrderCode();
        $payload['created_at'] = date('Y-m-d H:i:s');
        $payload['user_id'] = Auth::id();

        $payload['cart'] = [
            'detail' => $carts,
            'total' => $carts->total,
            'count' => $carts->count
        ];
        $payload['promotion'] = [
            'discount' => $cartPromotion['discount'],
            'name' => $cartPromotion['promotion']->name ?? '',
            'start_at' => $cartPromotion['promotion']->start_at ?? '',
            'end_at' => $cartPromotion['promotion']->end_at ?? '',
        ];
        $payload['confirm'] = 'pending';
        $payload['delivery'] = 'pending';
        $payload['payment'] = 'unpaid';
        return $payload;
    }
}
