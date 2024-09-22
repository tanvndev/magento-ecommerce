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
            'search' => addslashes($request->search),
            'publish' => $request->publish,
            'archive' => $request->boolean('archive'),
        ];

        $pageSize = $request->pageSize;

        $data = $this->voucherRepository->pagination($select, $condition, $pageSize);

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

        $payload['start_at'] = convertToYyyyMmDdHhMmSs($payload['voucher_time'][0] ?? null);
        $payload['end_at'] = convertToYyyyMmDdHhMmSs($payload['voucher_time'][1] ?? null);

        return $payload;
    }

    // CLIENT API //

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
                'publish' => 1,
                'start_at' => ['<=', date('Y-m-d H:i:s')],
            ],
        ];

        $pageSize = $request->pageSize;

        $data = $this->voucherRepository->pagination($select, $condition, $pageSize);

        return $data;
    }
}
