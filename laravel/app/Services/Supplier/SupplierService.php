<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Supplier;

use App\Repositories\Interfaces\Supplier\SupplierRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Supplier\SupplierServiceInterface;
use Illuminate\Support\Facades\DB;

class SupplierService extends BaseService implements SupplierServiceInterface
{
    protected $supplierRepository;
    public function __construct(
        SupplierRepositoryInterface $supplierRepository,
    ) {
        $this->supplierRepository = $supplierRepository;
    }
    public function paginate()
    {
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['publish'] = request('publish');
        $condition['searchFields'] = ['company_name', 'contact_name', 'contact_phone', 'contact_email', 'address'];

        $select = [
            'id', 'description', 'company_name', 'address',
            'contact_name', 'contact_phone', 'contact_email',
        ];

        if (request('pageSize') && request('page')) {
            $suppliers = $this->supplierRepository->pagination(
                $select,
                $condition,
                request('pageSize'),
                ['id' => 'desc'],
            );

            foreach ($suppliers as $key => $supplierCatalogue) {
                $supplierCatalogue->key = $supplierCatalogue->id;
            }
        } else {
            $suppliers = $this->supplierRepository->all($select);
        }

        return [
            'status' => 'success',
            'messages' => '',
            'data' => $suppliers
        ];
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');

            $this->supplierRepository->create($payload);

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
                'messages' => $e->getMessage(),
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

            $this->supplierRepository->update($id, $payload);

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
            $this->supplierRepository->delete($id);
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
