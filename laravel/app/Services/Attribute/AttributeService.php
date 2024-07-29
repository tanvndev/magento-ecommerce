<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Attribute;

use App\Classes\Upload;
use App\Repositories\Interfaces\Attribute\AttributeRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Attribute\AttributeServiceInterface;
use Illuminate\Support\Facades\DB;

class AttributeService extends BaseService implements AttributeServiceInterface
{
    protected $attributeRepository;
    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
    ) {
        $this->attributeRepository = $attributeRepository;
    }
    public function paginate()
    {
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['publish'] = request('publish');

        $attributes = $this->attributeRepository->pagination(
            ['id', 'name', 'attribute_catalogue_id'],
            $condition,
            request('pageSize'),
            ['id' => 'desc'],
            [],
            ['attribute_catalogues']
        );

        foreach ($attributes as $key => $attributeCatalogue) {
            $attributeCatalogue->key = $attributeCatalogue->id;
        }


        return [
            'status' => 'success',
            'messages' => '',
            'data' => $attributes
        ];
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');

            // Format payload
            $payload = $this->formatPayload($payload);

            $this->attributeRepository->createBatch($payload);

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

    private function formatPayload($payload)
    {
        // Xu ly thuoc tinh san pham
        $names = array_filter(array_map('trim', explode('|', $payload['name'])));

        return array_map(function ($name) use ($payload) {
            return [
                'name' => $name,
                'attribute_catalogue_id' => $payload['attribute_catalogue_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $names);
    }

    public function update($id)
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
            $payload = request()->except('_token', '_method');

            $this->attributeRepository->update($id, $payload);

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
            $this->attributeRepository->delete($id);
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
