<?php

namespace App\Services\Cart;

use App\Services\BaseService;
use App\Models\AttributeValue;
use App\Services\Interfaces\Cart\CartServiceInterface;
use App\Repositories\Interfaces\Cart\CartRepositoryInterface;
use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;
use App\Repositories\Interfaces\Attribute\AttributeValueRepositoryInterface;

class CartService extends BaseService implements CartServiceInterface
{
    protected
        $cartRepository,
        $productVariantRepository,
        $attributeValueRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductVariantRepositoryInterface $productVariantRepository,
        AttributeValueRepositoryInterface $attributeValueRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->attributeValueRepository = $attributeValueRepository;
    }


    public function getCart()
    {
        $userId = auth()->user()->id;

        $cart = $this->cartRepository->findByWhere(["user_id" => $userId], ['*'], ["cart_items.product_variant.attribute_values"]);

        $result = [];

        if (!empty($cart) && !empty($cart->cart_items)) {
            foreach ($cart->cart_items as $cartItem) {
                $productVariant = $cartItem['product_variant'];

                $result[] = [
                    'quantity' => $cartItem['quantity'],
                    'name' => $productVariant['name'],
                    'price' => $productVariant['price'],
                    'sale_price' => $productVariant['sale_price'],
                    'image' => $productVariant['image'],
                    'attributes' => implode(' - ', array_column($productVariant['attribute_values']->toArray(), 'name'))
                ];
            }
        }

        return $result;
    }

    public function CreateOrUpdate($request)
    {

        return $this->executeInTransaction(function () use ($request) {

            $userId                     = auth()->user()->id;

            $productVariant             = $this->productVariantRepository->findById($request->product_variant_id);

            $cart                       = $this->cartRepository->findByWhere(["user_id" => $userId]);

            if ($productVariant->stock < $request->quantity) {
                return errorResponse(__('messages.cart.error.max'));
            }

            if ($productVariant->stock === 1) {
                return errorResponse(__('messages.cart.error.min'));
            }

            if (!$cart) {
                $cart = $this->cartRepository->create([
                    'user_id'             => $userId,
                    'total_amount'        => 0
                ]);
            }

            $existingCartItem = $cart->cart_items()->where('product_variant_id', $productVariant->id)->first();

            if ($existingCartItem) {

                $newQuantity = $existingCartItem->quantity + ($request->plus ? $request->quantity : -$request->quantity);

                if ($newQuantity > $productVariant->stock) {
                    return errorResponse(__('messages.cart.error.max'));
                }

                $existingCartItem->update(['quantity' => $newQuantity]);
            } else {
                $cart->cart_items()->create([
                    'product_variant_id'    => $request->product_variant_id,
                    'quantity'              => $request->quantity,
                    'is_selected'           => 1
                ]);
            }


            $cart->update([
                'total_amount' => $cart->cart_items->sum(function ($item) use ($productVariant) {
                    return $item->quantity * ($productVariant->price_sale ?? $productVariant->price);
                })
            ]);

            return $existingCartItem
                ? successResponse(__('messages.cart.success.update'))
                : successResponse(__('messages.cart.success.create'));
        }, __('messages.cart.error.not_found'));
    }

    public function deleteOneItem($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $userId = auth()->user()->id;

            $cart = $this->cartRepository->findByWhere(["user_id" => $userId]);

            $cartItem = $cart->cart_items()->where('id', $id)->first();

            if ($cartItem) {
                if ($cart->cart_items->count() === 1) {
                    $cart->delete();
                } else {
                    $cartItem->delete();
                }
            } else {
                return errorResponse(__('messages.cart.error.item_not_found'));
            }

            $cart->update([
                'total_amount' => $cart->cart_items->sum(function ($item) {
                    return $item->quantity * ($item->product_variant->price_sale ?? $item->product_variant->price);
                })
            ]);

            return successResponse(__('messages.cart.success.delete'));
        }, __('messages.cart.error.item_not_found'));
    }

    public function deleteAllCart() {}
}
