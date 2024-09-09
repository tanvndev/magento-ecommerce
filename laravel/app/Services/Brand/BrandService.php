<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Brand;

use App\Repositories\Interfaces\Brand\BrandRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Brand\BrandServiceInterface;

class BrandService extends BaseService implements BrandServiceInterface
{
    protected $brandRepository;

    public function __construct(
        BrandRepositoryInterface $brandRepository,
    ) {
        $this->brandRepository = $brandRepository;
    }

    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),

        ];
        $select = ['id', 'name', 'publish', 'description', 'canonical', 'image', 'is_featured'];
        $pageSize = request('pageSize');

        $data = $pageSize && request('page')
            ? $this->brandRepository->pagination($select, $condition, $pageSize)
            : $this->brandRepository->findByWhere(['publish' => 1], $select, [], true);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();
            $this->brandRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->brandRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
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
            $this->brandRepository->delete($id);

            return successResponse(__('messages.delete.success'));
        }, __('messages.delete.error'));
    }
}
