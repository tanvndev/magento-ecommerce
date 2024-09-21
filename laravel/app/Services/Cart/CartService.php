<?php

namespace App\Services\Cart;

use App\Services\BaseService;
use App\Services\Interfaces\Cart\CartServiceInterface;
use App\Repositories\Interfaces\Cart\CartRepositoryInterface;
use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;

class CartService extends BaseService implements CartServiceInterface
{
    protected CartRepositoryInterface                   $cartRepository;
    protected ProductVariantRepositoryInterface         $productVariantRepository;

    public function __construct(
        CartRepositoryInterface                         $cartRepository,
        ProductVariantRepositoryInterface               $productVariantRepository
    ) {
        $this->cartRepository                           = $cartRepository;
        $this->productVariantRepository                 = $productVariantRepository;
    }

    public function getCart($sessionId = null)
    {
        $conditions                                     = $this->getUserOrSessionConditions($sessionId);

        $this->checkStockProductAndUpdateCart($conditions);

        $cart                                           = $this->cartRepository->findByWhere(
            $conditions,
            ['*'],
            ['cart_items.product_variant.attribute_values']
        );

        return $cart->cart_items ?? collect();
    }

    public function createOrUpdate($request, $sessionId = null)
    {
        return $this->executeInTransaction(function () use ($request, $sessionId) {
            if (!$request->product_variant_id) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $productVariant                             = $this->productVariantRepository->findById($request->product_variant_id);
            if ($productVariant->stock < $request->quantity) {
                return errorResponse(__('messages.cart.error.max'));
            }

            $conditions                                 = $this->getUserOrSessionConditions($sessionId);
            $cart                                       = $this->cartRepository->findByWhere($conditions) ?? $this->cartRepository->create($conditions);

            $cart->cart_items()->where('product_variant_id', $request->product_variant_id)->exists()
                ? $this->updateCartItem($cart, $request)
                : $this->createCartItem($cart, $request);

            return $this->getCart($sessionId);
        }, __('messages.cart.error.not_found'));
    }

    private function createCartItem($cart, $request)
    {
        $cart->cart_items()->create([
            'product_variant_id'                        => $request->product_variant_id,
            'quantity'                                  => $request->quantity ?? 1,
            'updated_at'                                => now(),
        ]);
    }

    private function updateCartItem($cart, $request)
    {
        $cartItem                                       = $cart->cart_items()->where('product_variant_id', $request->product_variant_id)->first();
        $quantity                                       = $request->quantity ?? $cartItem->quantity + 1;
        $cartItem->update([
            'quantity'                                  => $quantity,
            'updated_at'                                => now(),
        ]);
    }

    public function checkStockProductAndUpdateCart($conditions)
    {
        $cart = $this->cartRepository->findByWhere($conditions);

        foreach ($cart->cart_items as $item) {
            $productVariant = $this->productVariantRepository->findById($item->product_variant_id);
            if ($productVariant->stock < $item->quantity) {
                $item->update(['quantity' => $productVariant->stock]);
            }
        }

        $sessionId = request()->input('session_id', null);
        $this->mergeSessionCartToUserCart($sessionId);
    }



    public function deleteOneItem($id, $sessionId = null)
    {
        return $this->executeInTransaction(function () use ($id, $sessionId) {
            $conditions                                 = $this->getUserOrSessionConditions($sessionId);
            $cart                                       = $this->cartRepository->findByWhere($conditions);

            if (!$cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $cartItem                                   = $cart->cart_items()->where('product_variant_id', $id)->first();

            $cartItem?->delete();

            return $this->getCart($sessionId);
        }, __('messages.cart.error.item_not_found'));
    }

    public function cleanCart($sessionId = null)
    {
        return $this->executeInTransaction(function () use ($sessionId) {
            $conditions                                 = $this->getUserOrSessionConditions($sessionId);
            $cart                                       = $this->cartRepository->findByWhere($conditions);

            if (!$cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $cart->cart_items()->delete();
            return successResponse(__('messages.cart.success.clean'));
        }, __('messages.cart.error.delete'));
    }

    public function handleSelected($request, $sessionId = null)
    {
        return $this->executeInTransaction(function () use ($request, $sessionId) {
            $conditions                                 = $this->getUserOrSessionConditions($sessionId);
            $cart                                       = $this->cartRepository->findByWhere($conditions);

            if (!$cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            if (isset($request->product_variant_id)) {
                $this->toggleCartItemSelection($cart, $request->product_variant_id);
            }

            if (isset($request->select_all)) {
                $cart->cart_items()->update(['is_selected' => (bool)$request->select_all, 'updated_at' => now()]);
            }

            return $this->getCart($sessionId);
        }, __('messages.cart.error.not_found'));
    }

    public function deleteCartSelected($sessionId = null)
    {
        return $this->executeInTransaction(function () use ($sessionId) {
            $conditions = $this->getUserOrSessionConditions($sessionId);
            $cart = $this->cartRepository->findByWhere($conditions);

            if (!$cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $selectedItems = $cart->cart_items()->where('is_selected', true)->get();

            foreach ($selectedItems as $item) {
                $item->delete();
            }

            return $this->getCart($sessionId);
        }, __('messages.cart.error.delete'));
    }


    private function toggleCartItemSelection($cart, $productId)
    {
        $cartItem                                       = $cart->cart_items()->where('product_variant_id', $productId)->first();

        if ($cartItem) {
            $cartItem->update(['is_selected'            => !$cartItem->is_selected, 'updated_at' => now()]);
        }
    }

    private function getUserOrSessionConditions($sessionId): array
    {
        return auth()->check()
            ? ['user_id' => auth()->user()->id]
            : ['session_id' => $sessionId];
    }

    public function mergeSessionCartToUserCart($sessionId)
    {
        if (!auth()->check()) {
            return;
        }

        $userId = auth()->user()->id;
        $userCart = $this->cartRepository->findByWhere(['user_id' => $userId]);
        $sessionCart = $this->cartRepository->findByWhere(['session_id' => $sessionId]);

        if (!$sessionCart) {
            return;
        }

        if (!$userCart) {
            $userCart = $this->cartRepository->create(['user_id' => $userId]);
        }

        foreach ($sessionCart->cart_items as $sessionItem) {

            $existingItem = $userCart->cart_items()->where('product_variant_id', $sessionItem->product_variant_id)->first();

            if ($existingItem) {

                $existingItem->update([
                    'quantity' => $existingItem->quantity + $sessionItem->quantity,
                    'updated_at' => now(),
                ]);
            } else {

                $userCart->cart_items()->create([
                    'product_variant_id' => $sessionItem->product_variant_id,
                    'quantity' => $sessionItem->quantity,
                ]);
            }
        }

        $sessionCart->cart_items()->delete();
    }
}
