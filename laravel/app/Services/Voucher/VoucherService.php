<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Voucher;

use App\Models\Voucher;
use App\Repositories\Interfaces\Voucher\VoucherRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Voucher\VoucherServiceInterface;

class VoucherService extends BaseService implements VoucherServiceInterface
{
    protected $voucherRepository;

    public function __construct(
        VoucherRepositoryInterface $voucherRepository,
    ) {
        $this->voucherRepository = $voucherRepository;
    }

    public function paginate()
    {
        $select = ['id', 'name', 'publish', 'description', 'code', 'image'];

        $data = request('list')
            ? $this->voucherRepository->findByWhere(['publish' => 1], $select)
            : $this->voucherRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();
            $this->voucherRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->voucherRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->voucherRepository->delete($id);

            return successResponse(__('messages.delete.success'));
        }, __('messages.delete.error'));
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');

        return $payload;
    }

    public function applyCoupon($request)
    {
        /*
            $request nhận dữ liệu: ['code' => 'ABC', 'subtotal' => '700']
            'code': Dữ liệu người dùng nhập vào form
            'subtotal': Tổng tiền trong giỏ hàng
        */
        $subtotal = $request->subtotal;
        $voucher = Voucher::where('code', $request->code)->first();


        if (!$voucher) {
            return errorResponse(__('messages.voucher.error.invalid'));
        }

        // Kiểm tra số lượng mã giảm giá
        if ($voucher->quantity <= 0) {
            return errorResponse(__('messages.voucher.error.min'));
        }

        // Kiểm tra thời gian mã giảm giá
        if ($voucher->end_at < now()) {
            return errorResponse(__('messages.voucher.error.expired'));
        }

        // Kiểm tra tổng giá trị đơn hàng
        if ($request->subtotal < $voucher->min_order_value) {
            return errorResponse(__('messages.voucher.error.min'));
        }


        if ($voucher->discount_type === "percent") {
            $discount = $subtotal * ($voucher->discount_value / 100);
        } else if ($voucher->discount_type === "amount") {
            $discount = $voucher->discount_value;
        }
        $finaleTotal = $subtotal - $discount;

        // Khi thành công update lại số lượng voucher-
        $newQuantity = $voucher->quantity  - 1;
        $voucher->update(['quantity' => $newQuantity]);


        return  successResponse(__('messages.voucher.success'), [
            'dismount'      => $discount,
            'finaleTotal'   => $finaleTotal,
        ]);
    }
}
