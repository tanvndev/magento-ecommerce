<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Voucher;

use App\Models\Voucher;
use App\Repositories\Interfaces\Voucher\VoucherRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Voucher\VoucherServiceInterface;
use App\Repositories\Interfaces\Cart\CartRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class VoucherService extends BaseService implements VoucherServiceInterface
{
    protected $voucherRepository;

    protected $cartRepository;

    public function __construct(
        VoucherRepositoryInterface $voucherRepository,
        CartRepositoryInterface $cartRepository
    ) {
        $this->voucherRepository = $voucherRepository;
        $this->cartRepository = $cartRepository;
    }


    /**
     * Get all vouchers and filter with condition from request.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginate()
    {
        $request = request();

        $select = [
            'id',
            'name',
            'code',
            'image',
            'description',
            'value_type',
            'value',
            'value_limit_amount',
            'quantity',
            'condition_apply',
            'subtotal_price',
            'min_quantity',
            'start_at',
            'end_at',
            'publish',
        ];

        $condition = [
            'search'  => addslashes($request->search),
            'publish' => $request->publish,
            'archive' => $request->boolean('archive'),
        ];

        $pageSize = $request->pageSize;

        $data = $this->voucherRepository->pagination($select, $condition, $pageSize);

        return $data;
    }

    /**
     * Create a new voucher
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();
            $this->voucherRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function update(string $id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->voucherRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }


    /**
     * Destroy the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->voucherRepository->delete($id);

            return successResponse(__('messages.delete.success'));
        }, __('messages.delete.error'));
    }

    /**
     * Prepare payload for voucher update/create.
     *
     * @return array
     */
    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');

        $payload['start_at'] = convertToYyyyMmDdHhMmSs($payload['voucher_time'][0] ?? null);
        $payload['end_at'] = convertToYyyyMmDdHhMmSs($payload['voucher_time'][1] ?? null);

        return $payload;
    }

    // CLIENT API //

    /**
     * Get all voucher active
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAllVoucher()
    {
        $request = request();

        $select = [
            'id',
            'name',
            'code',
            'image',
            'description',
            'value_type',
            'value',
            'value_limit_amount',
            'quantity',
            'condition_apply',
            'subtotal_price',
            'min_quantity',
            'start_at',
            'end_at',
        ];

        $condition = [
            'where' => [
                'publish'  => 1,
                'start_at' => ['<=', date('Y-m-d H:i:s')],
            ],
        ];

        $pageSize = $request->pageSize;

        $data = $this->voucherRepository->pagination($select, $condition, $pageSize);

        return $data;
    }

    /**
     * Get cart items by user id.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    private function getCartItems(int $userId)
    {
        $relation = [
            [
                'cart_items' => function ($query) {
                    $query->where('is_selected', true);
                },
                'cart_items.product_variant' => function ($query) {
                    $query->whereHas('product', function ($q) {
                        $q->where('publish', 1);
                    });
                },
            ],
        ];

        $cart = $this->cartRepository->findByWhere(['user_id' => $userId], ['*'], $relation);

        if (! $cart) {
            throw new \Exception('Cart not found.');
        }

        return $cart->cart_items;
    }

    /**
     * Apply voucher to order
     *
     * @param string $code
     *
     * @return array
     */
    public function applyVoucher(string $code)
    {
        $userId = auth()->user()->id;

        $cartItems = $this->getCartItems($userId);
        $totalPrice = $this->calculateTotalPrice($cartItems);

        $voucher = $this->voucherRepository->findByWhere(['code' => $code]);

        $condition = $this->handleConditionVoucher($voucher, $cartItems, $totalPrice);

        if (!$condition) {
            return errorResponse(__('messages.voucher.error.apply'));
        }

        $discount = $this->getDisount($voucher, $totalPrice);
        $data = [
            'voucher_id' => $voucher->id,
            'discount' => $discount,
        ];

        return successResponse(__('messages.voucher.success.apply'), $data);
    }


    /**
     * Calculate discount value
     *
     * @param Voucher $voucher
     * @param float $totalPrice
     *
     * @return float
     */
    private function getDisount(Voucher $voucher, float $totalPrice): float
    {
        $discount = 0;
        if ($voucher->value_type === Voucher::TYPE_PERCENT) {
            $discount = min($totalPrice * ($voucher->value / 100), $voucher->value_limit_amount);
        } elseif ($voucher->value_type === Voucher::TYPE_FIXED) {
            $discount = $voucher->value;
        }

        return $discount;
    }

    /**
     * Handle condition voucher before apply to cart
     *
     * @param Voucher $voucher
     * @param Collection $cartItems
     * @param float $totalPrice
     *
     * @return bool
     */
    /**
     * Conditions:
     * - Voucher is not expired
     * - Voucher is still available (quantity > 0)
     * - Subtotal price of cart is greater than or equal to subtotal price of voucher
     * - Min quantity of voucher is less than or equal to quantity of items in cart
     * - Apply to all items in cart
     *
     * @return bool
     */
    private function handleConditionVoucher(Voucher $voucher, Collection $cartItems, float $totalPrice): bool
    {
        $now = Carbon::now();
        $startAt = Carbon::parse($voucher->start_at);
        $endAt = Carbon::parse($voucher->end_at);

        if ($endAt->lt($now) || $startAt->gt($now)) {
            return false;
        }

        if ($voucher->quantity <= 0) {
            return false;
        }

        switch ($voucher->condition_apply) {
            case Voucher::SUBTOTAL_PRICE:
                return $voucher->subtotal_price <= $totalPrice;

            case Voucher::ALL:
                return true;

            case Voucher::MIN_QUANTITY:
                return $voucher->min_quantity <= $cartItems->count();

            default:
                return false;
        }
    }

    /**
     * Calculate total price of cart items.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $cartItems
     * @return float
     */
    private function calculateTotalPrice($cartItems): float
    {
        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $productVariant = $item->product_variant;
            $quantity = $item->quantity;

            $price = $this->getEffectivePrice($productVariant);

            if ($price != null) {
                $totalPrice += $price * $quantity;
            }
        }

        return $totalPrice;
    }

    /**
     * Get the effective price of a product variant, taking into account the sale price
     * and discount time.
     *
     * If the sale price is valid, return the sale price. Otherwise, return the original
     * price if $returnOriginalPrice is true, or null if it is false.
     *
     * @param  \App\Models\ProductVariant  $productVariant
     * @param  bool  $returnOriginalPrice
     * @return float|null
     */
    private function getEffectivePrice($productVariant, bool $returnOriginalPrice = true): ?float
    {
        if ($this->isSalePriceValid($productVariant)) {
            return $productVariant->sale_price;
        }

        return $returnOriginalPrice ? $productVariant->price : null;
    }

    /**
     * Determine if the sale price of a product variant is valid.
     *
     * A sale price is valid if it has a value and the product variant has a price.
     * If the product variant has a discount time,
     * the sale price is valid if the current time is between the start and end times
     * of the discount time.
     * If the product variant does not have a discount time,
     * the sale price is valid.
     *
     * @param  \App\Models\ProductVariant  $productVariant
     * @return bool
     */
    private function isSalePriceValid($productVariant): bool
    {
        if (! $productVariant->sale_price || ! $productVariant->price) {
            return false;
        }

        if ($productVariant->is_discount_time) {
            if ($productVariant->sale_price_start_at && $productVariant->sale_price_end_at) {
                $now = now();
                $start = Carbon::parse($productVariant->sale_price_start_at);
                $end = Carbon::parse($productVariant->sale_price_end_at);

                if ($now > $start || $now < $end) {
                    return true;
                }
            }
        } else {
            return true;
        }

        return false;
    }
}
