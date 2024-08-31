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
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),

        ];
        $select = ['id', 'name', 'publish', 'description', 'code', 'image'];
        $pageSize = request('pageSize');

        $data = $pageSize && request('page')
            ? $this->shippingMethodRepository->pagination($select, $condition, $pageSize)
            : $this->shippingMethodRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();
            $this->shippingMethodRepository->create($payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->shippingMethodRepository->update($id, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');
        $payload = $this->createSEO($payload);

        return $payload;
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->shippingMethodRepository->delete($id);

            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại.');
    }
}
