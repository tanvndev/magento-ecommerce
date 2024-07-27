<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Product;


use App\Repositories\Interfaces\Product\ProductCatalogueRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Product\ProductCatalogueServiceInterface;
use Illuminate\Support\Facades\DB;

class ProductCatalogueService extends BaseService implements ProductCatalogueServiceInterface
{
    protected $productCatalogueRepository;
    protected $productRepository;
    public function __construct(
        ProductCatalogueRepositoryInterface $productCatalogueRepository,
    ) {
        $this->productCatalogueRepository = $productCatalogueRepository;
    }
    public function paginate()
    {
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['publish'] = request('publish');
        $select = ['id', 'name', 'code', 'publish'];

        if (request('pageSize') && request('page')) {
            $productCatalogues = $this->productCatalogueRepository->pagination(
                $select,
                $condition,
                request('pageSize'),
                ['id' => 'desc'],
                [],
                []
            );
            foreach ($productCatalogues as $key => $productCatalogue) {
                $productCatalogue->key = $productCatalogue->id;
            }
        } else {
            $productCatalogues = $this->productCatalogueRepository->all($select);
        }

        return [
            'status' => 'success',
            'messages' => '',
            'data' => $productCatalogues ?? []
        ];
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');
            if (!isset($payload['code']) || empty($payload['code'])) {
                $payload['code'] = $this->convertToCode($payload['name']);
            }
            $this->productCatalogueRepository->create($payload);
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
            if (!isset($payload['code']) || empty($payload['code'])) {
                $payload['code'] = $this->convertToCode($payload['name']);
            } else {
                $payload['code'] = strtoupper($payload['code']);
            }
            $this->productCatalogueRepository->update($id, $payload);

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
            $this->productCatalogueRepository->delete($id);
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


    public function setPermission()
    {
        DB::beginTransaction();
        try {
            $permissions = request('permission');
            foreach ($permissions as $key => $value) {
                $productCatalogue = $this->productCatalogueRepository->findById($key);
                $productCatalogue->permissions()->sync($value);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    // Hàm này thay đổi trạng thái của product khi thay đổi trạng thái product catalogue
    private function changeProductStatus($dataPost)
    {
        DB::beginTransaction();
        try {
            $arrayId = [];
            $value = '';

            // Là một mảng thì là Chọn tất cả còn k là ngược lại chọn 1 để update publish
            if (isset($dataPost['id'])) {
                $arrayId = $dataPost['id'];
                $value = $dataPost['value'];
            } else {
                $arrayId[] = $dataPost['modelId'];
                $value = $dataPost['value'] == 1 ? 0 : 1;
            }
            $payload[$dataPost['field']] = $value;

            $update = $this->productRepository->updateByWhereIn('product_catalogue_id', $arrayId, $payload);

            if (!$update) {
                DB::rollBack();
                return false;
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }
}
