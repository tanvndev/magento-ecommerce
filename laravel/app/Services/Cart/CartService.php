<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Services\BaseService;
use App\Services\Interfaces\Cart\CartServiceInterface;
use App\Repositories\Interfaces\Cart\CartRepositoryInterface;
use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;

class CartService extends BaseService implements CartServiceInterface
{
    protected $cartRepository;
    protected $productVariantRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductVariantRepositoryInterface $productVariantRepository
    ) {
        $this->cartRepository               = $cartRepository;
        $this->productVariantRepository     = $productVariantRepository;
    }

    public function getCart()
    {
        $userId = auth()->user()->id;

        $this->addToCartFromSession($userId);

        $cart = $this->cartRepository->findByWhere(
            ["user_id" => $userId],
            ['*'],
            ["cart_items.product_variant.attribute_values"]
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

            $userId = auth()->user()->id;

            $cart = $this->cartRepository->findByWhere(["user_id" => $userId]);

            if (!$cart) {
                $cart = $this->cartRepository->create(['user_id' => $userId]);
            }

            if ($cart->cart_items()->where('product_variant_id', $request->product_variant_id)->exists()) {
                $this->update($cart, $request);
            } else {
                $this->create($cart, $request);
            }
            return $this->getCart();
        }, __('messages.cart.error.not_found'));
    }

    private function create($cart, $request)
    {
        $cart->cart_items()->create([
            'product_variant_id'    => $request->product_variant_id,
            'quantity'              => 1
        ]);
    }

    private function update($cart, $request)
    {
        $cartItem =  $cart->cart_items()->where('product_variant_id', $request->product_variant_id)->first();
        $quantity = $request->quantity ?? $cartItem->quantity + 1;
        $cartItem->update([
            'quantity'              => $quantity
        ]);
    }

    public function addToCartFromSession($userId)
    {
        $cart                                   = $this->cartRepository->findByWhere($userId);

        if ($cart->cart_items()->count() > 0) {
            foreach ($cart->cart_items as $item) {
                $productVariant                 = $this->productVariantRepository->findById($item->product_variant_id);
                if ($productVariant->stock < $item->quantity) {
                    $item->update(['quantity'   => $productVariant->stock]);
                }
            }
        }
    }




    public function deleteOneItem($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $userId = auth()->user()->id;
            $cart = $this->cartRepository->findByWhere(['user_id' => $userId]);

            if (! $cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            $cartItem = $cart->cart_items()->where('product_variant_id', $id)->first();

            if ($cartItem) {
                $cartItem->delete();
            }

            return successResponse(__('messages.cart.success.delete'));
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

            return successResponse(__('messages.cart.success.clean'));
        }, __('messages.cart.error.delete'));
    }

    public function handleSelected($request)
    {
        return $this->executeInTransaction(function () use ($request) {
            $userId                                 = auth()->user()->id;
            $cart                                   = $this->cartRepository->findByWhere(["user_id" => $userId]);

            if (!$cart) {
                return errorResponse(__('messages.cart.error.not_found'));
            }

            if (isset($request->product_variant_id)) {
                $cartItem                           = $cart->cart_items()->where('product_variant_id', $request->product_variant_id)->first();

                if ($cartItem) {
                    $cartItem->is_selected          = !$cartItem->is_selected;
                    $cartItem->save();
                }
            }

            if (isset($request->select_all)) {
                $result = $request->select_all == 1 ? true : false;
                $cart->cart_items()->update(['is_selected' => $result]);
            }

            return successResponse(__('messages.cart.success.publish'));
        }, __('messages.cart.error.not_found'));
    }
}
