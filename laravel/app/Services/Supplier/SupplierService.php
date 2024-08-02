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
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
            'searchFields' => ['company_name', 'contact_name', 'contact_phone', 'contact_email', 'address'],
        ];
        $pageSize = request('pageSize');
        $select = [
            'id', 'description', 'company_name', 'address',
            'contact_name', 'contact_phone', 'contact_email',
        ];

        $data = $pageSize && request('page')
            ? $this->supplierRepository->pagination($select, $condition, $pageSize)
            : $this->supplierRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = request()->except('_token', '_method');
            $this->supplierRepository->create($payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }


    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = request()->except('_token', '_method');
            $this->supplierRepository->update($id, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
    }


    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->supplierRepository->delete($id);
            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại.');
    }
}
