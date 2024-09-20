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

    public function getCart()
    {
        $conditions                                     = $this->getUserOrSessionConditions();

        $this->checkStockProductAndUpdateCart($conditions);

        $cart                                           = $this->cartRepository->findByWhere(
            $conditions,
            ['*'],
            ['cart_items.product_variant.attribute_values']
        );

        return $cart->cart_items ?? collect();
    }

    public function createOrUpdate($request)
    {
        return $this->executeInTransaction(function () use ($request) {
            if (!$request->product_variant_id) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $productVariant                             = $this->productVariantRepository->findById($request->product_variant_id);
            if ($productVariant->stock < $request->quantity) {
                return errorResponse(__('messages.cart.error.max'));
            }

            $conditions                                 = $this->getUserOrSessionConditions();
            $cart                                       = $this->cartRepository->findByWhere($conditions) ?? $this->cartRepository->create($conditions);

            $cart->cart_items()->where('product_variant_id', $request->product_variant_id)->exists()
                ? $this->updateCartItem($cart, $request)
                : $this->createCartItem($cart, $request);

            return $this->getCart();
        }, __('messages.cart.error.not_found'));
    }

    private function createCartItem($cart, $request)
    {
        $cart->cart_items()->create([
<<<<<<< HEAD
            'product_variant_id' => $request->product_variant_id,
            'quantity'           => 1,
=======
            'product_variant_id'                        => $request->product_variant_id,
            'quantity'                                  => $request->quantity ?? 1,
            'updated_at'                                => now(),
>>>>>>> 03d7105 (Update Cart Session Module)
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
        $cart                                           = $this->cartRepository->findByWhere($conditions);

        foreach ($cart->cart_items as $item) {
            $productVariant                             = $this->productVariantRepository->findById($item->product_variant_id);
            if ($productVariant->stock < $item->quantity) {
                $item->update(['quantity'               => $productVariant->stock]);
            }
        }
    }

    public function deleteOneItem($request, $id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $conditions                                 = $this->getUserOrSessionConditions();
            $cart                                       = $this->cartRepository->findByWhere($conditions);

            if (!$cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $cartItem                                   = $cart->cart_items()->where('product_variant_id', $id)->first();
            $cartItem?->delete();

            return $this->getCart();
        }, __('messages.cart.error.item_not_found'));
    }

    public function cleanCart()
    {
        return $this->executeInTransaction(function () {
            $conditions                                 = $this->getUserOrSessionConditions();
            $cart                                       = $this->cartRepository->findByWhere($conditions);

            if (!$cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $cart->cart_items()->delete();
            return successResponse(__('messages.cart.success.clean'));
        }, __('messages.cart.error.delete'));
    }

    public function handleSelected($request)
    {
        return $this->executeInTransaction(function () use ($request) {
            $conditions                                 = $this->getUserOrSessionConditions();
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

            return $this->getCart();
        }, __('messages.cart.error.not_found'));
    }

    private function toggleCartItemSelection($cart, $productId)
    {
        $cartItem                                       = $cart->cart_items()->where('product_variant_id', $productId)->first();

        if ($cartItem) {
            $cartItem->update(['is_selected'            => !$cartItem->is_selected, 'updated_at' => now()]);
        }
    }

    private function getUserOrSessionConditions(): array
    {
        return auth()->check()
            ? ['user_id' => auth()->user()->id]
            : ['session_id' => request()->input('session_id')];
    }
}
