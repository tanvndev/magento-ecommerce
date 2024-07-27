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
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['publish'] = request('publish');
        $select = ['id', 'name', 'publish', 'description', 'canonical'];

        if (request('pageSize') && request('page')) {

            $brands = $this->brandRepository->pagination(
                ['id', 'name', 'publish', 'description', 'canonical'],
                $condition,
                request('pageSize'),
                ['id' => 'desc'],
            );

            foreach ($brands as $key => $brandCatalogue) {
                $brandCatalogue->key = $brandCatalogue->id;
            }
        } else {
            $brands = $this->brandRepository->all($select);
        }


        return [
            'status' => 'success',
            'messages' => '',
            'data' => $brands
        ];
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');

            $this->brandRepository->create($payload);

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

            $this->brandRepository->update($id, $payload);

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
            $this->brandRepository->delete($id);
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
