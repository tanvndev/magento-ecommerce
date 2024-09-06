<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\ShippingMethod;

use App\Repositories\Interfaces\ShippingMethod\ShippingMethodRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\ShippingMethod\ShippingMethodServiceInterface;

class ShippingMethodService extends BaseService implements ShippingMethodServiceInterface
{
    protected $shippingMethodRepository;

    public function __construct(
        ShippingMethodRepositoryInterface $shippingMethodRepository,
    ) {
        $this->shippingMethodRepository = $shippingMethodRepository;
    }

    public function paginate()
    {
        $select = ['id', 'name', 'publish', 'description', 'base_cost', 'image'];
        $data = $this->shippingMethodRepository->all($select);

        return $data;
    }

    public function list()
    {
        $data = $this->shippingMethodRepository->findByWhere(['publish' => 1]);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();
            $this->shippingMethodRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->shippingMethodRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');

        return $payload;
    }
}
