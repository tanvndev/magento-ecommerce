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
            if ( ! $request->product_variant_id) {
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

    /**
     * Check stock of product variants in cart and update cart.
     *
     * If a product variant's stock is less than the quantity of the cart item, update the quantity of the cart item to the stock of the product variant.
     * Finally, merge session cart to user cart.
     *
     * @param  array  $conditions
     */
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

    /**
     * Delete one item from the cart.
     *
     * This method deletes one item from the cart by product variant id.
     * If the item is not found, it returns a error response.
     * If the item is found, it deletes the item and returns the cart.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOneItem($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $sessionId = request('session_id', 0);
            $conditions = $this->getUserOrSessionConditions($sessionId);
            $cart = $this->cartRepository->findByWhere($conditions);

            if ( ! $cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $cartItem = $cart->cart_items()->where('product_variant_id', $id)->first();

            $cartItem?->delete();

            return $this->getCart();
        }, __('messages.cart.error.item_not_found'));
    }

    /**
     * Clean the entire cart.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cleanCart()
    {
        return $this->executeInTransaction(function () {

            $sessionId = request('session_id', 0);
            $conditions = $this->getUserOrSessionConditions($sessionId);
            $cart = $this->cartRepository->findByWhere($conditions);

            if ( ! $cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $cart->cart_items()->delete();

            return successResponse(__('messages.cart.success.clean'));
        }, __('messages.cart.error.delete'));
    }

    /**
     * Handle selected items in the cart.
     *
     * If the request has a "product_variant_id" key, the method will toggle the selected status of the specified cart item.
     *
     * If the request has a "select_all" key with a boolean value, the method will update the selected status of all the cart items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleSelected($request)
    {
        return $this->executeInTransaction(function () use ($request) {

            $sessionId = request('session_id', 0);
            $conditions = $this->getUserOrSessionConditions($sessionId);
            $cart = $this->cartRepository->findByWhere($conditions);

            if ( ! $cart) {
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

    /**
     * Delete selected items from the cart.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCartSelected()
    {
        return $this->executeInTransaction(function () {

            $sessionId = request('session_id', 0);
            $conditions = $this->getUserOrSessionConditions($sessionId);
            $cart = $this->cartRepository->findByWhere($conditions);

            if ( ! $cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $selectedItems = $cart->cart_items()->where('is_selected', true)->get();

            foreach ($selectedItems as $item) {
                $item->delete();
            }

            return $this->getCart();
        }, __('messages.cart.error.delete'));
    }

    /**
     * Toggle cart item selection.
     *
     * @param  \App\Models\Cart  $cart
     * @param  int  $productId
     */
    private function toggleCartItemSelection($cart, $productId): void
    {
        $cartItem = $cart->cart_items()->where('product_variant_id', $productId)->first();

        if ($cartItem) {
            $cartItem->update(['is_selected' => ! $cartItem->is_selected, 'updated_at' => now()]);
        }
    }

    /**
     * Get conditions for querying cart based on user or session ID.
     *
     * @param  int  $sessionId
     */
    private function getUserOrSessionConditions($sessionId): array
    {
        return auth()->check()
            ? ['user_id' => auth()->user()->id]
            : ['session_id' => $sessionId];
    }

    /**
     * Merge session cart to user cart when user logged in.
     *
     * @param  int  $sessionId
     */
    public function mergeSessionCartToUserCart($sessionId): void
    {
        if ( ! auth()->check()) {
            return;
        }

        $userId = auth()->user()->id;
        $userCart = $this->cartRepository->findByWhere(['user_id' => $userId]);
        $sessionCart = $this->cartRepository->findByWhere(['session_id' => $sessionId]);

        if ( ! $sessionCart) {
            return;
        }

        if ( ! $userCart) {
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

    /**
     * Add paid products to the cart.
     *
     * This method takes the paid product variant ids from the request and adds them to the cart.
     * It also checks if the product variant is available in the stock and updates the cart item quantity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Update quantity of a cart item.
     *
     * @param  \App\Models\CartItem  $cartItem
     */
    private function updateCartItemQuantity($cartItem, int $additionalQuantity): void
    {
        $newQuantity = $cartItem->quantity + $additionalQuantity;

        $cartItem->update([
            'quantity' => $newQuantity,
            'updated_at' => now(),
        ]);
    }
}
