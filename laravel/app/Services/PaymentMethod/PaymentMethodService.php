<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\PaymentMethod;

use App\Repositories\Interfaces\PaymentMethod\PaymentMethodRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\PaymentMethod\PaymentMethodServiceInterface;

class PaymentMethodService extends BaseService implements PaymentMethodServiceInterface
{
    protected $paymentMethodRepository;

    public function __construct(
        PaymentMethodRepositoryInterface $paymentMethodRepository,
    ) {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),

        ];
        $select = ['id', 'name', 'publish', 'description', 'code', 'image'];
        $pageSize = request('pageSize');

        $data = $pageSize && request('page')
            ? $this->paymentMethodRepository->pagination($select, $condition, $pageSize)
            : $this->paymentMethodRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();
            $this->paymentMethodRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->paymentMethodRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');

        return $payload;
    }
}