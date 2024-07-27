<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Permission;


use App\Repositories\Interfaces\Permission\PermissionRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Permission\PermissionServiceInterface;
use Illuminate\Support\Facades\DB;

class PermissionService extends BaseService implements PermissionServiceInterface
{
    protected $permissionRepository;
    protected $userRepository;
    public function __construct(
        PermissionRepositoryInterface $permissionRepository,
    ) {
        $this->permissionRepository = $permissionRepository;
    }
    public function paginate()
    {
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['searchFields'] = ['canonical'];
        $condition['publish'] = request('publish');
        $select = ['id', 'name', 'canonical'];

        if (request('pageSize') && request('page')) {
            $permissions = $this->permissionRepository->pagination(
                $select,
                $condition,
                request('pageSize'),
                ['id' => 'desc'],

            );
            foreach ($permissions as $key => $permission) {
                $permission->key = $permission->id;
            }
        } else {
            $permissions = $this->permissionRepository->all($select);
        }

        return [
            'status' => 'success',
            'messages' => '',
            'data' => $permissions ?? []
        ];
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            $payload = request()->except('_token');

            // Thực hiện tạo nhanh thông tin quyền
            if (isset($payload['canonical']) && strpos($payload['canonical'], ':') !== false) {

                $canonicals = explode(':', $payload['canonical']);
                // dd($canonicals);

                if (count($canonicals) >= 3) {
                    $canonicalName = trim(lcfirst($canonicals[0]));
                    $CRUD = trim($canonicals[1]);
                    $name = trim(lcfirst($canonicals[2]));

                    $dataToInsert = [];
                    $date = now()->toDateTimeString();
                    if (strpos($CRUD, 'C') !== false) {
                        $dataToInsert[] = [
                            'name' => "Tạo mới {$name}",
                            'canonical' => "{$canonicalName}.store",
                            'created_at' => $date,
                            'updated_at' => $date,
                        ];
                    }
                    if (strpos($CRUD, 'R') !== false) {
                        $dataToInsert[] = [
                            'name' => "Xem nhiều {$name}",
                            'canonical' => "{$canonicalName}.index",
                            'created_at' => $date,
                            'updated_at' => $date,
                        ];
                        $dataToInsert[] = [
                            'name' => "Xem một {$name}",
                            'canonical' => "{$canonicalName}.show",
                            'created_at' => $date,
                            'updated_at' => $date,
                        ];
                    }
                    if (strpos($CRUD, 'U') !== false) {
                        $dataToInsert[] = [
                            'name' => "Chỉnh sửa {$name}",
                            'canonical' => "{$canonicalName}.update",
                            'created_at' => $date,
                            'updated_at' => $date,
                        ];
                    }
                    if (strpos($CRUD, 'D') !== false) {
                        $dataToInsert[] = [
                            'name' => "Xóa {$name}",
                            'canonical' => "{$canonicalName}.destroy",
                            'created_at' => $date,
                            'updated_at' => $date,
                        ];
                    }
                    $this->permissionRepository->createBatch($dataToInsert);
                }
            } else {
                // Thực hiện insert với payload gốc
                $this->permissionRepository->create($payload);
            }
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
                'messages' => 'Thêm mới thất bại',
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
            $this->permissionRepository->update($id, $payload);

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
            $this->permissionRepository->delete($id);
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

    public function switch($id)
    {
    }
}
