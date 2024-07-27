<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Product;

use App\Classes\Upload;
use App\Repositories\Interfaces\Product\ProductRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Product\ProductServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductService extends BaseService implements ProductServiceInterface
{
    protected $productRepository;
    public function __construct(
        ProductRepositoryInterface $productRepository,
    ) {
        $this->productRepository = $productRepository;
    }
    public function paginate()
    {
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['searchFields'] = ['fullname', 'email', 'phone', 'address'];
        $condition['publish'] = request('publish');

        $products = $this->productRepository->pagination(
            ['id', 'fullname', 'email', 'phone', 'address', 'publish'],
            $condition,
            request('pageSize'),
            ['id' => 'desc'],
        );

        foreach ($products as $key => $productCatalogue) {
            $productCatalogue->key = $productCatalogue->id;
        }

        return [
            'status' => 'success',
            'messages' => '',
            'data' => $products
        ];
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');
            $payload['password'] = Hash::make($payload['password']);
            $payload['product_agent'] = request()->header('Product-Agent');
            $payload['ip'] = request()->ip();

            // Xu ly anh resize
            if (isset($payload['image']) && !empty($payload['image'])) {
                $urlImage = Upload::uploadImage($payload['image']);
                $payload['image'] = $urlImage;
            }

            $this->productRepository->create($payload);
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
            $this->productRepository->update($id, $payload);

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
            $this->productRepository->delete($id);
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
