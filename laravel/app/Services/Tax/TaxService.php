<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Tax;

use App\Repositories\Interfaces\Tax\TaxRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Tax\TaxServiceInterface;
use Illuminate\Support\Facades\DB;

class TaxService extends BaseService implements TaxServiceInterface
{
    protected $taxRepository;
    public function __construct(
        TaxRepositoryInterface $taxRepository,
    ) {
        $this->taxRepository = $taxRepository;
    }
    public function paginate()
    {
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['searchFields'] = ['name', 'code', 'rate'];
        $condition['publish'] = request('publish');
        $select = ['id', 'name', 'publish', 'code', 'rate'];

        if (request('pageSize') && request('page')) {

            $taxs = $this->taxRepository->pagination(
                $select,
                $condition,
                request('pageSize'),
                ['id' => 'desc'],
            );

            foreach ($taxs as $key => $taxCatalogue) {
                $taxCatalogue->key = $taxCatalogue->id;
            }
        } else {
            $taxs = $this->taxRepository->all($select);
        }


        return [
            'status' => 'success',
            'messages' => '',
            'data' => $taxs
        ];
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');

            $this->taxRepository->create($payload);

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

            $this->taxRepository->update($id, $payload);

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
            $this->taxRepository->delete($id);
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
