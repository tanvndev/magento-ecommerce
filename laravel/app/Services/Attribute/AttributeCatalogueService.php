<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Attribute;


use App\Repositories\Interfaces\Attribute\AttributeCatalogueRepositoryInterface;
use App\Services\Interfaces\Attribute\AttributeCatalogueServiceInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class AttributeCatalogueService extends BaseService implements AttributeCatalogueServiceInterface
{
    protected $attributeCatalogueRepository;
    protected $attributeRepository;
    public function __construct(
        AttributeCatalogueRepositoryInterface $attributeCatalogueRepository,
    ) {
        $this->attributeCatalogueRepository = $attributeCatalogueRepository;
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
            ? $this->attributeCatalogueRepository->pagination($select, $condition, $pageSize)
            : $this->attributeCatalogueRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = request()->except('_token', '_method');
            $this->attributeCatalogueRepository->create($payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }


    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = request()->except('_token', '_method');
            $this->attributeCatalogueRepository->update($id, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->attributeCatalogueRepository->delete($id);
            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại.');
    }
}
