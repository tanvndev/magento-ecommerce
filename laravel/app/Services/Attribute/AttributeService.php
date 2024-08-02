<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Attribute;

use App\Repositories\Interfaces\Attribute\AttributeRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Attribute\AttributeServiceInterface;
use Illuminate\Support\Facades\DB;

class AttributeService extends BaseService implements AttributeServiceInterface
{
    protected $attributeRepository;
    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
    ) {
        $this->attributeRepository = $attributeRepository;
    }
    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
        ];
        $select = ['id', 'name', 'attribute_catalogue_id'];

        $data = request('pageSize') && request('page')
            ?
            $this->attributeRepository->pagination(
                $select,
                $condition,
                request('pageSize'),
                ['id' => 'desc'],
                [],
                ['attribute_catalogue'],
            )
            :
            $this->attributeRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {
            $payload = request()->except('_token', '_method');
            $payload = $this->formatPayload($payload);

            $this->attributeRepository->createBatch($payload);
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
                'attribute_catalogue_id' => $payload['attribute_catalogue_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $names);
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = request()->except('_token', '_method');
            $this->attributeRepository->update($id, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
    }


    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->attributeRepository->delete($id);
            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại.');
    }
}
