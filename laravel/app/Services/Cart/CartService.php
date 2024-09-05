<?php

namespace App\Services\Cart;

use App\Repositories\Interfaces\Cart\CartRepositoryInterface;
use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Cart\CartServiceInterface;

class CartService extends BaseService implements CartServiceInterface
{
    protected
        $cartRepository,
        $productVariantRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductVariantRepositoryInterface $productVariantRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->productVariantRepository = $productVariantRepository;
    }


    public function getCart()
    {
        $user = auth()->user();
        $cart = [];
        foreach ($user->cart as $item) {
            $cart[] = $item->cartItems;
        }
        return $cart;
        // return $this->cartRepository->all();
    }

    public function StoreOrUpdate($request)
    {
        return $this->executeInTransaction(function () use ($request) {

            $productVariant             = $this->productVariantRepository->findById($request->product_variant_id);

            $cart                       = $this->cartRepository->findByWhere(auth()->user()->id);

            if ($productVariant->stock < $request->quantity) {
                return errorResponse('Số lượng trong kho không đủ!');
            }

            if (!$cart) {
                $cart = $this->cartRepository->create([
                    'user_id'             => auth()->user()->id,
                    'total_amount'        => 0
                ]);
            }


            $existingCartItem = $cart->cartItems()->where('product_variant_id', $productVariant->id)->first();

            if ($existingCartItem) {

                if ($existingCartItem->quantity + $request->quantity > $productVariant->stock) {
                    return errorResponse('messages.cart.create.stock');
                }

                $existingCartItem->update([
                    'quantity'              => $existingCartItem->quantity + $request->quantity
                ]);
            } else {
                $cart->cartItems()->create([
                    'product_variant_id'    => $request->product_variant_id,
                    'quantity'              => $request->quantity,
                    'is_selected'           => 1
                ]);
            }


            $cart->update([
                'total_amount' => $cart->cartItems->sum(function ($item) use ($productVariant) {
                    return $item->quantity * ($productVariant->price_sale ?? $productVariant->price);
                })
            ]);


            return successResponse(__('messages.cart.create.success'));
        }, __('messages.cart.create.error'));
    }

    public function deleteOneItem($request) {}

    public function deleteAllCart() {}
}
