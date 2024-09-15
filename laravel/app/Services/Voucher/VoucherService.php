<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Voucher;

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
            'publish',
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
            if ($payload['min_order_value']) {
                $payload['min_quantity'] = null;
            }
            if ($payload['min_quantity']) {
                $payload['min_order_value'] = null;
            }

            $this->voucherRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();

            if ($payload['min_order_value'] && $payload['min_quantity']) {
                return errorResponse(__('messages.voucher.error.create'));
            }
            if ($payload['min_order_value']) {
                $payload['min_quantity'] = null;
            }
            if ($payload['min_quantity']) {
                $payload['min_order_value'] = null;
            }

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
}
