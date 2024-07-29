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
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['publish'] = request('publish');
        $select = ['id', 'name', 'code', 'description', 'publish'];

        if (request('pageSize') && request('page')) {
            $attributeCatalogues = $this->attributeCatalogueRepository->pagination(
                $select,
                $condition,
                request('pageSize'),
                ['id' => 'desc'],
            );
            foreach ($attributeCatalogues as $key => $attributeCatalogue) {
                $attributeCatalogue->key = $attributeCatalogue->id;
            }
        } else {
            $attributeCatalogues = $this->attributeCatalogueRepository->all($select, ['attributes']);
        }

        return [
            'status' => 'success',
            'messages' => '',
            'data' => $attributeCatalogues ?? []
        ];
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');

            $this->attributeCatalogueRepository->create($payload);

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

            $this->attributeCatalogueRepository->update($id, $payload);

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
            $this->attributeCatalogueRepository->delete($id);

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
