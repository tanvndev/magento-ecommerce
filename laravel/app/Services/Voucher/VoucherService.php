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
        $select = [
            'id',
            'name',
            'code',
            'image',
            'description',
            'discount_type',
            'discount_value',
            'quantity',
            'min_order_value',
            'min_quantity',
            'start_at',
            'end_at',
            'publish'
        ];


        $data = request('list')
            ? $this->voucherRepository->findByWhere(['publish' => 1], $select)
            : $this->voucherRepository->all($select);
        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();

            if ($payload['min_order_value'] && $payload['min_quantity']) {
                return errorResponse(__('messages.voucher.error.create'));
            }
            if ($payload['min_order_value'])  $payload['min_quantity'] = null;
            if ($payload['min_quantity'])  $payload['min_order_value'] = null;



            $this->voucherRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();

            if ($payload['min_order_value'])  $payload['min_quantity'] = null;
            if ($payload['min_quantity'])  $payload['min_order_value'] = null;

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

    public function applyVoucher($request)
    {
        return $this->executeInTransaction(function () use ($request) {

            /*
                $request nhận dữ liệu: ['code' => 'ABC', 'subtotal' => '700', 'cart_quantity' => 5]
                'code': Dữ liệu người dùng nhập vào form
                'subtotal': Tổng tiền trong giỏ hàng
                'cart_quantity': Số lượng sản phẩm trong giỏ hàng
            */

            $subtotal = $request->subtotal;
            $voucher = $this->voucherRepository->findByWhere(['code' => $request->code, 'publish' => 1]);


            if (!$voucher) {
                return errorResponse(__('messages.voucher.error.invalid'));
            }

            // Kiểm tra số lượng mã giảm giá
            if ($voucher->quantity <= 0) {
                return errorResponse(__('messages.voucher.error.over'));

                // Nếu quantity đã bằng không thì xóa
            }

            // Kiểm tra thời gian mã giảm giá
            if ($voucher->end_at < now() || now() < $voucher->start_at) {
                return errorResponse(__('messages.voucher.error.expired'));

                // Nếu thời gian đã quá hạn thì xóa
            }

            if ($voucher->end_at < now() || now() < $voucher->start_at) {
                return errorResponse(__('messages.voucher.error.expired'));

                // Nếu thời gian đã quá hạn thì xóa
            }


            if ($voucher->min_order_value && $voucher->min_quantity == null) {
                // Kiểm tra tổng giá trị đơn hàng
                if ($request->subtotal < $voucher->min_order_value) {
                    return errorResponse(__('messages.voucher.error.min'));
                }
            } else {
                // Kiểm tra tổng giá trị đơn hàng
                if ($request->cart_quantity < $voucher->min_quantity) {
                    return errorResponse(__('messages.voucher.error.min'));
                }
            }


            // Tính tiền được khuyến mại và tiền phải trả sau khuyến mại
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
        }, __('messages.voucher.error.invalid'));
    }
}
