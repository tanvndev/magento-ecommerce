<?php

namespace App\Services\Cart;

use App\Services\BaseService;
use App\Services\Interfaces\Cart\CartServiceInterface;
use App\Repositories\Interfaces\Cart\CartRepositoryInterface;
use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;
use Gloudemans\Shoppingcart\Facades\Cart;

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
        if (auth()->check()) {
            $userId = auth()->user()->id;
            $cart = $this->cartRepository->findByWhere(
                ["user_id" => $userId],
                ['*'],
                ["cart_items.product_variant.attribute_values"]
            );

            return $cart->cart_items ?? collect();
        }

        return Cart::instance('shopping')->content();
    }

    public function createOrUpdate($request)
    {
        return $this->executeInTransaction(function () use ($request) {
            $productVariant = $this->productVariantRepository->findById($request->product_variant_id);

            if ($productVariant->stock < $request->quantity) {
                return errorResponse(__('messages.cart.error.max'));
            }

            if ($productVariant->stock === 1) {
                return errorResponse(__('messages.cart.error.min'));
            }

            if (auth()->check()) {
                $userId = auth()->user()->id;
                $cart = $this->cartRepository->findByWhere(["user_id" => $userId]);

                if (!$cart) {
                    $cart = $this->cartRepository->create(['user_id' => $userId]);
                }

                $existingCartItem = $cart->cart_items()->where('product_variant_id', $productVariant->id)->first();

                if ($existingCartItem) {
                    $existingCartItem->update(['quantity' => $request->quantity]);
                } else {
                    $cart->cart_items()->create([
                        'product_variant_id'    => $request->product_variant_id,
                        'quantity'              => $request->quantity ?? 1,
                    ]);
                }

                return successResponse(__('messages.cart.success.update'));
            } else {

                // Cart::add([
                //     'id'                        => $productVariant->id,
                //     'name'                      => $productVariant->name,
                //     'qty'                       => $request->quantity,
                //     'price'                     => $productVariant->price_sale ?? $productVariant->price,
                // ]);

                Cart::instance('shopping')->add([
                    'id'                        => $productVariant->id,
                    'name'                      => $productVariant->name,
                    'qty'                       => $request->quantity,
                    'price'                     => $productVariant->price_sale ?? $productVariant->price,
                ]);

                return successResponse(__('messages.cart.success.create'),  Cart::content());
            }
        }, __('messages.cart.error.not_found'));
    }

    public function deleteOneItem($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            if (auth()->check()) {
                $userId = auth()->user()->id;
                $cart = $this->cartRepository->findByWhere(["user_id" => $userId]);

                if (!$cart) {
                    return errorResponse(__('messages.cart.error.not_found'));
                }

                $cartItem = $cart->cart_items()->where('id', $id)->first();

                if ($cartItem) {
                    $cartItem->delete();
                    return successResponse(__('messages.cart.success.delete'));
                } else {
                    return errorResponse(__('messages.cart.error.item_not_found'));
                }
            } else {

                Cart::remove($id);
                return successResponse(__('messages.cart.success.delete'));
            }
        }, __('messages.cart.error.item_not_found'));
    }

    public function cleanCart()
    {
        return $this->executeInTransaction(function () {
            if (auth()->check()) {
                $user = auth()->user();

                if (!$user->cart) {
                    return errorResponse(__('messages.cart.error.cart_not_found'));
                }

                $user->cart->delete();
            } else {

                Cart::destroy();
            }

            return successResponse(__('messages.cart.success.clear'));
        }, __('messages.cart.error.delete'));
    }

    public function handleSelected($request)
    {
        return $this->executeInTransaction(function () use ($request) {
            if (auth()->check()) {
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

                $totalAmount = $this->calculateTotalAmount($cart);

                return successResponse(__('messages.cart.success.update'), [
                    'total_amount' => $totalAmount
                ]);
            } else {

                if (isset($request->product_variant_id)) {
                    $cartItem = Cart::content()->where('id', $request->product_variant_id)->first();

                    if ($cartItem) {

                        $cartItem->is_selected = !$cartItem->is_selected;
                    }
                }

                if (isset($request->select_all)) {

                    foreach (Cart::content() as $item) {
                        $item->is_selected = $request->select_all == 1;
                    }
                }


                $totalAmount = $this->calculateTotalAmountFromSession();

                return successResponse(__('messages.cart.success.update'), [
                    'total_amount' => $totalAmount
                ]);
            }
        }, __('messages.cart.error.not_found'));
    }

    protected function calculateTotalAmount($cart)
    {
        return $cart->cart_items->sum(function ($item) {
            return $item->is_selected ? $item->quantity * ($item->product_variant->price_sale ?? $item->product_variant->price) : 0;
        });
    }

    protected function calculateTotalAmountFromSession()
    {
        return Cart::content()->sum(function ($item) {
            return $item->is_selected ? $item->qty * $item->price : 0;
        });
    }
}
