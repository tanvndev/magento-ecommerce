<?php

namespace App\Services\Cart;

use App\Repositories\Interfaces\Cart\CartRepositoryInterface;
use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Cart\CartServiceInterface;

class CartService extends BaseService implements CartServiceInterface
{
    protected CartRepositoryInterface $cartRepository;

    protected ProductVariantRepositoryInterface $productVariantRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductVariantRepositoryInterface $productVariantRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->productVariantRepository = $productVariantRepository;
    }

    public function getCart()
    {
        $sessionId = request('session_id', 0);
        $conditions = $this->getUserOrSessionConditions($sessionId);

        $this->checkStockProductAndUpdateCart($conditions);

        $cart = $this->cartRepository->findByWhere(
            $conditions,
            ['*'],
            ['cart_items.product_variant.attribute_values']
        );

        return $cart->cart_items ?? collect();
    }

    public function createOrUpdate($request)
    {
        return $this->executeInTransaction(function () use ($request) {
            if (! $request->product_variant_id) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $productVariant = $this->productVariantRepository->findById($request->product_variant_id);
            if ($productVariant->stock < $request->quantity) {
                return errorResponse(__('messages.cart.error.max'));
            }

            $sessionId = request('session_id', 0);

            $conditions = $this->getUserOrSessionConditions($sessionId);
            $cart = $this->cartRepository->findByWhere($conditions) ?? $this->cartRepository->create($conditions);

            $cart->cart_items()->where('product_variant_id', $request->product_variant_id)->exists()
                ? $this->updateCartItem($cart, $request)
                : $this->createCartItem($cart, $request);

            return $this->getCart();
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
        $cartItem = $cart->cart_items()->where('product_variant_id', $request->product_variant_id)->first();
        $quantity = $request->quantity ?? $cartItem->quantity + 1;
        $cartItem->update([
            'quantity'   => $quantity,
            'updated_at' => now(),
        ]);
    }

    public function checkStockProductAndUpdateCart($conditions)
    {
        $cart = $this->cartRepository->findByWhere($conditions);

        if (! $cart) {
            return;
        }

        foreach ($cart->cart_items as $item) {
            $productVariant = $this->productVariantRepository->findById($item->product_variant_id);
            if ($productVariant->stock < $item->quantity) {
                $item->update(['quantity' => $productVariant->stock]);
            }
        }

        $sessionId = request('session_id', 0);
        $this->mergeSessionCartToUserCart($sessionId);
    }

    public function deleteOneItem($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $sessionId = request('session_id', 0);
            $conditions = $this->getUserOrSessionConditions($sessionId);
            $cart = $this->cartRepository->findByWhere($conditions);

            if (! $cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $cartItem = $cart->cart_items()->where('product_variant_id', $id)->first();

            $cartItem?->delete();

            return $this->getCart();
        }, __('messages.cart.error.item_not_found'));
    }

    public function cleanCart()
    {
        return $this->executeInTransaction(function () {

            $sessionId = request('session_id', 0);
            $conditions = $this->getUserOrSessionConditions($sessionId);
            $cart = $this->cartRepository->findByWhere($conditions);

            if (! $cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $cart->cart_items()->delete();

            return successResponse(__('messages.cart.success.clean'));
        }, __('messages.cart.error.delete'));
    }

    public function handleSelected($request)
    {
        return $this->executeInTransaction(function () use ($request) {

            $sessionId = request('session_id', 0);
            $conditions = $this->getUserOrSessionConditions($sessionId);
            $cart = $this->cartRepository->findByWhere($conditions);

            if (! $cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            if (isset($request->product_variant_id)) {
                $this->toggleCartItemSelection($cart, $request->product_variant_id);
            }

            if (isset($request->select_all)) {
                $cart->cart_items()->update(['is_selected' => (bool) $request->select_all, 'updated_at' => now()]);
            }

            return $this->getCart();
        }, __('messages.cart.error.not_found'));
    }

    public function deleteCartSelected()
    {
        return $this->executeInTransaction(function () {

            $sessionId = request('session_id', 0);
            $conditions = $this->getUserOrSessionConditions($sessionId);
            $cart = $this->cartRepository->findByWhere($conditions);

            if (! $cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $selectedItems = $cart->cart_items()->where('is_selected', true)->get();

            foreach ($selectedItems as $item) {
                $item->delete();
            }

            return $this->getCart();
        }, __('messages.cart.error.delete'));
    }

    private function toggleCartItemSelection($cart, $productId)
    {
        $cartItem = $cart->cart_items()->where('product_variant_id', $productId)->first();

        if ($cartItem) {
            $cartItem->update(['is_selected' => ! $cartItem->is_selected, 'updated_at' => now()]);
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
        if (! auth()->check()) {
            return;
        }

        $userId = auth()->user()->id;
        $userCart = $this->cartRepository->findByWhere(['user_id' => $userId]);
        $sessionCart = $this->cartRepository->findByWhere(['session_id' => $sessionId]);

        if (! $sessionCart) {
            return;
        }

        if (! $userCart) {
            $userCart = $this->cartRepository->create(['user_id' => $userId]);
        }

        foreach ($sessionCart->cart_items as $sessionItem) {

            $existingItem = $userCart->cart_items()->where('product_variant_id', $sessionItem->product_variant_id)->first();

            if ($existingItem) {

                $existingItem->update([
                    'quantity'   => $existingItem->quantity + $sessionItem->quantity,
                    'updated_at' => now(),
                ]);
            } else {

                $userCart->cart_items()->create([
                    'product_variant_id' => $sessionItem->product_variant_id,
                    'quantity'           => $sessionItem->quantity,
                ]);
            }
        }

        $sessionCart->cart_items()->delete();
    }

    public function addPaidProductsToCart($request)
    {
        return $this->executeInTransaction(function () use ($request) {

            $productVariantIds = explode(',', $request->get('product_variant_id'));

            if (empty($productVariantIds)) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $conditions = $this->getUserOrSessionConditions('');

            $cart = $this->cartRepository->findByWhere($conditions) ?? $this->cartRepository->create($conditions);

            foreach ($productVariantIds as $productVariantId) {
                $productVariant = $this->productVariantRepository->findById($productVariantId);

                if ($productVariant->stock < 1) {
                    return errorResponse(__('messages.cart.error.max'));
                }

                $cartItem = $cart->cart_items()->where('product_variant_id', $productVariantId)->first();

                if ($cartItem) {
                    $this->updateCartItemQuantity($cartItem, 1);
                } else {

                    $this->createCartItem($cart, (object) ['product_variant_id' => $productVariantId, 'quantity' => 1]);
                }
            }

            return $this->getCart();
        }, __('messages.cart.error.not_found'));
    }

    private function updateCartItemQuantity($cartItem, $additionalQuantity)
    {
        $newQuantity = $cartItem->quantity + $additionalQuantity;

        $cartItem->update([
            'quantity' => $newQuantity,
            'updated_at' => now(),
        ]);
    }
}
