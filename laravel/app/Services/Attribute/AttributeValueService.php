<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Attribute;

use App\Repositories\Interfaces\Attribute\AttributeValueRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Attribute\AttributeValueServiceInterface;

class AttributeValueService extends BaseService implements AttributeValueServiceInterface
{
    protected $attributeValueRepository;

    public function __construct(
        AttributeValueRepositoryInterface $attributeValueRepository,
    ) {
        $this->attributeValueRepository = $attributeValueRepository;
    }

    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),

        ];

        if (! empty(request('attribute_id'))) {
            $condition['where'] = [
                'attribute_id' => ['=', request('attribute_id')],
            ];
        }

        $select = ['id', 'name', 'attribute_id'];

        $data = request('pageSize') && request('page')
            ?
            $this->attributeValueRepository->pagination(
                $select,
                $condition,
                request('pageSize'),
                ['id' => 'desc'],
                [],
                ['attribute'],
            )
            :
            $this->attributeValueRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {
            $payload = request()->except('_token', '_method');
            $payload = $this->formatPayload($payload);

            $this->attributeValueRepository->createBatch($payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }

    private function formatPayload($payload)
    {
        // Xu ly thuoc tinh san pham
        $names = array_filter(array_map('trim', explode('|', $payload['name'])));

        return array_map(function ($name) use ($payload) {
            return [
                'name' => $name,
                'attribute_id' => $payload['attribute_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $names);
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = request()->except('_token', '_method');
            $this->attributeValueRepository->update($id, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->attributeValueRepository->delete($id);

            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại.');
    }
}
