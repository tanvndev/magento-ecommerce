<?php

namespace App\Services\Cart;

use App\Services\BaseService;
use App\Services\Interfaces\Cart\CartServiceInterface;
use App\Repositories\Interfaces\Cart\CartRepositoryInterface;
use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;

class CartService extends BaseService implements CartServiceInterface
{
    protected
        $cartRepository,
        $productVariantRepository,
        $attributeValueRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductVariantRepositoryInterface $productVariantRepository,
    ) {
        $this->cartRepository = $cartRepository;
        $this->productVariantRepository = $productVariantRepository;
    }


    public function getCart()
    {
        $userId     = auth()->user()->id;

        $cart       = $this->cartRepository
            ->findByWhere(
                ["user_id" => $userId],
                ['*'],
                ["cart_items.product_variant.attribute_values"]
            );

        return $cart->cart_items ?? collect();
    }

    public function createOrUpdate($request)
    {
        // return $request->all();
        return $this->executeInTransaction(function () use ($request) {
            $userId = auth()->user()->id;
            $productVariant = $this->productVariantRepository->findById($request->product_variant_id);
            $cart = $this->cartRepository->findByWhere(["user_id" => $userId]);

            if ($productVariant->stock < $request->quantity) {
                return errorResponse(__('messages.cart.error.max'));
            }

            if ($productVariant->stock === 1) {
                return errorResponse(__('messages.cart.error.min'));
            }

            if (!$cart) {
                $cart = $this->cartRepository->create([
                    'user_id' => $userId,
                    'total_amount' => 0
                ]);
            }

            $existingCartItem = $cart->cart_items()->where('product_variant_id', $productVariant->id)->first();

            if ($existingCartItem) {
                $newQuantity = $existingCartItem->quantity + ($request->minus ? -1 : 1);

                if (!isset($request->minus) && !isset($request->plus)) {
                    $newQuantity = $request->quantity;
                }

                if ($newQuantity > $productVariant->stock) {
                    return errorResponse(__('messages.cart.error.max'));
                }

                if ($newQuantity < 1) {
                    return errorResponse(__('messages.cart.error.min'));
                }


                $existingCartItem->update(['quantity' => $newQuantity]);

                $totalAmount = $this->calculateTotalAmount($cart);
                $cart->update(['total_amount' => $totalAmount]);

                $total = $existingCartItem->quantity * ($productVariant->price_sale ?? $productVariant->price);

                return successResponse(__('messages.cart.success.update'), [
                    'cart_item' => [
                        'id' => $existingCartItem->id,
                        'quantity' => $existingCartItem->quantity,
                        'is_selected' => $existingCartItem->is_selected,
                        'total' => $total,
                        'total_amount' => $totalAmount
                    ]
                ]);
            } else {
                $existingCartItem = $cart->cart_items()->create([
                    'product_variant_id' => $request->product_variant_id,
                    'quantity' => $request->quantity,
                ]);

                $totalAmount = $this->calculateTotalAmount($cart);
                $cart->update(['total_amount' => $totalAmount]);

                return successResponse(__('messages.cart.success.create'));
            }
        }, __('messages.cart.error.not_found'));
    }

    public function deleteOneItem($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $userId = auth()->user()->id;

            $cart = $this->cartRepository->findByWhere(["user_id" => $userId]);

            if (!$cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $cartItem = $cart->cart_items()->where('id', $id)->first();

            if ($cartItem) {

                $totalToSubtract = $cartItem->is_selected ? $cartItem->quantity * ($cartItem->product_variant->price_sale ?? $cartItem->product_variant->price) : 0;

                if ($cart->cart_items->count() === 1) {
                    $cart->delete();
                } else {
                    $cartItem->delete();
                }

                $cart->update([
                    'total_amount' => $cart->cart_items->sum(function ($item) {
                        return $item->quantity * ($item->product_variant->price_sale ?? $item->product_variant->price);
                    }) - $totalToSubtract
                ]);

                return successResponse(__('messages.cart.success.delete'));
            } else {
                return errorResponse(__('messages.cart.error.item_not_found'));
            }
        }, __('messages.cart.error.item_not_found'));
    }



    public function cleanCart()
    {

        return $this->executeInTransaction(function () {
            $user = auth()->user();

            if (!$user->cart) {
                return errorResponse(__('messages.cart.error.cart_not_found'));
            }

            $user->cart->delete();

            return successResponse(__('messages.cart.success.clear'));
        }, __('messages.cart.error.delete'));
    }

    public function handleSelected($request)
    {
        return $this->executeInTransaction(function () use ($request) {
            $userId = auth()->user()->id;
            $cart = $this->cartRepository->findByWhere(["user_id" => $userId]);

            if (!$cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            if (isset($request->product_variant_id)) {
                $cartItem = $cart->cart_items()->where('product_variant_id', $request->product_variant_id)->first();

                if ($cartItem) {
                    $cartItem->is_selected = !$cartItem->is_selected;
                    $cartItem->save();
                }
            }

            if (isset($request->select_all)) {
                $result = $request->select_all == 1 ? true : false;
                $cart->cart_items()->update(['is_selected' => $result]);
            }

            $totalAmount = $this->calculateTotalAmount($cart);
            $cart->update(['total_amount' => $totalAmount]);

            return successResponse(__('messages.cart.success.update'), [
                'total_amount' => $totalAmount
            ]);
        }, __('messages.cart.error.not_found'));
    }

    protected function calculateTotalAmount($cart)
    {
        return $cart->cart_items->sum(function ($item) {
            return $item->is_selected ? $item->quantity * ($item->product_variant->sale_price ?? $item->product_variant->price) : 0;
        });
    }
}
