<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Attribute;

use App\Repositories\Interfaces\Attribute\AttributeValueRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Attribute\AttributeValueServiceInterface;

class AttributeValueService extends BaseService implements AttributeValueServiceInterface
{
    protected $attributeValueRepository;

    protected $attributeRepository;

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
        $select = ['id', 'name', 'code', 'description', 'publish'];
        $pageSize = request('pageSize');

        $data = $pageSize && request('page')
            ? $this->attributeValueRepository->pagination($select, $condition, $pageSize)
            : $this->attributeValueRepository->all($select, ['attributes']);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = request()->except('_token', '_method');
            $this->attributeValueRepository->create($payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
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
