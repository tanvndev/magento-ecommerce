<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Warehouse;

use App\Classes\Upload;
use App\Repositories\Interfaces\Warehouse\WarehouseRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Warehouse\WarehouseServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WarehouseService extends BaseService implements WarehouseServiceInterface
{
    protected $warehouseRepository;
    public function __construct(
        WarehouseRepositoryInterface $warehouseRepository,
    ) {
        $this->warehouseRepository = $warehouseRepository;
    }
    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
            'searchFields' => ['name', 'code', 'phone', 'supervisor_name'],
        ];
        $select = ['id', 'name', 'code', 'phone', 'shelve', 'row', 'supervisor_name', 'publish'];
        $pageSize = request('pageSize');

        $data = $pageSize && request('page')
            ? $this->warehouseRepository->pagination($select, $condition, $pageSize)
            : $this->warehouseRepository->all($select);

        // Add key for table for frontend
        $data->transform(function ($item) {
            $item->key = $item->id;
            return $item;
        });

        return successResponse('', $data);
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = request()->except('_token', '_method');
            $this->warehouseRepository->create($payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = request()->except('_token', '_method');
            $this->warehouseRepository->update($id, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->warehouseRepository->delete($id);
            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại.');
    }
}
