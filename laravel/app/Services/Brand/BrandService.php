<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Brand;

use App\Repositories\Interfaces\Brand\BrandRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Brand\BrandServiceInterface;
use Illuminate\Support\Facades\DB;

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
        $select = ['id', 'name', 'publish', 'description', 'canonical', 'image'];
        $pageSize = request('pageSize');

        $data = $pageSize && request('page')
            ? $this->brandRepository->pagination($select, $condition, $pageSize)
            : $this->brandRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = request()->except('_token', '_method');
            $this->brandRepository->create($payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }


    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = request()->except('_token', '_method');
            $this->brandRepository->update($id, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
    }


    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->brandRepository->delete($id);
            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại.');
    }
}
