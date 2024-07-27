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
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['publish'] = request('publish');

        $select = ['id', 'name', 'code', 'phone', 'shelve', 'row', 'supervisor_name', 'publish'];
        if (request('pageSize') && request('page')) {

            $warehouses = $this->warehouseRepository->pagination(
                $select,
                $condition,
                request('pageSize'),
                ['id' => 'desc'],
            );
        } else {
            $warehouses = $this->warehouseRepository->all($select);
        }

        foreach ($warehouses as $key => $warehouseCatalogue) {
            $warehouseCatalogue->key = $warehouseCatalogue->id;
        }

        return [
            'status' => 'success',
            'messages' => '',
            'data' => $warehouses
        ];
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');

            $this->warehouseRepository->create($payload);
            DB::commit();
            return [
                'status' => 'success',
                'messages' => 'Thêm mới thành công.',
                'data' => null
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'messages' => 'Thêm mới thất bại.',
                'data' => null
            ];
        }
    }

    public function update($id)
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
            $payload = request()->except('_token', '_method');
            $this->warehouseRepository->update($id, $payload);

            DB::commit();
            return [
                'status' => 'success',
                'messages' => 'Cập nhập thành công.',
                'data' => null
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'messages' => 'Cập nhập thất bại.',
                'data' => null
            ];
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm
            $this->warehouseRepository->delete($id);
            DB::commit();
            return [
                'status' => 'success',
                'messages' => 'Xóa thành công.',
                'data' => null
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'messages' => 'Xóa thất bại.',
                'data' => null
            ];
        }
    }
}
