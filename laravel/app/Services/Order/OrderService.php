<?php

namespace App\Services\Order;

use App\Repositories\Interfaces\Order\OrderRepositoryInterface;
use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Order\OrderServiceInterface;

class OrderService extends BaseService implements OrderServiceInterface
{
    protected $orderRepository;

    protected $productVariantRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductVariantRepositoryInterface $productVariantRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productVariantRepository = $productVariantRepository;
    }

    public function paginate()
    {
        return $this->orderRepository->paginate();
    }


    public function create()
    {
        return $this->orderRepository->create();
    }


    public function update($id)
    {
        return $this->orderRepository->update($id);
    }

    public function order()
    {
        DB::beginTransaction();
        try {
            $payload = $this->handlePayloadOrder();

            $order = $this->orderRepository->create($payload);

            if ($order->id == null || empty($order->id)) {
                throw new \Exception('Error create order.');
            }
            $payload['id'] = $order->id;
            // Dong bo du lieu vao bang order_product
            $this->createOrderProduct($payload, $order);
            // Gui mail cho khach hang
            $this->sendMail($payload);
            DB::commit();
            return $payload;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
            die;
            return [];
        }
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

    private function generateOrderCode($prefix = 'ORD')
    {
        $prefix = strtoupper($prefix);
        $date = date('Ymd');
        $uniqueId = uniqid();
        $uniqueHash = substr(md5($uniqueId), 0, 6);
        $orderCode = $prefix  . $date  . strtoupper($uniqueHash);
        return $orderCode;
    }
}
