<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\User;


use App\Repositories\Interfaces\User\UserCatalogueRepositoryInterface;
use App\Repositories\Interfaces\User\UserRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\User\UserCatalogueServiceInterface;
use Illuminate\Support\Facades\DB;

class UserCatalogueService extends BaseService implements UserCatalogueServiceInterface
{
    protected $userCatalogueRepository;
    protected $userRepository;
    public function __construct(
        UserCatalogueRepositoryInterface $userCatalogueRepository,
    ) {
        $this->userCatalogueRepository = $userCatalogueRepository;
    }
    public function paginate()
    {
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['publish'] = request('publish');
        $select = ['id', 'name', 'description', 'publish', 'code'];

        if (request('pageSize') && request('page')) {
            $userCatalogues = $this->userCatalogueRepository->pagination(
                $select,
                $condition,
                request('pageSize'),
                ['id' => 'desc'],
                [],
                ['user']
            );
            foreach ($userCatalogues as $key => $userCatalogue) {
                $userCatalogue->key = $userCatalogue->id;
            }
        } else {
            $userCatalogues = $this->userCatalogueRepository->all($select, ['permissions']);
        }

        return [
            'status' => 'success',
            'messages' => '',
            'data' => $userCatalogues ?? []
        ];
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');
            $this->userCatalogueRepository->create($payload);
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
            $this->userCatalogueRepository->update($id, $payload);

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
            $this->userCatalogueRepository->delete($id);
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


    public function updatePermissions()
    {
        DB::beginTransaction();
        try {
            $permissions = json_decode(request('permissions'), true);
            foreach ($permissions as $key => $value) {
                $userCatalogue = $this->userCatalogueRepository->findById($key);
                if (empty($value)) {
                    $userCatalogue->permissions()->detach();
                } else {
                    $userCatalogue->permissions()->sync($value);
                }
            }
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

    // Hàm này thay đổi trạng thái của user khi thay đổi trạng thái user catalogue
    private function changeUserStatus($dataPost)
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

            $update = $this->userRepository->updateByWhereIn('user_catalogue_id', $arrayId, $payload);

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
