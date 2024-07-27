<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\User;

use App\Classes\Upload;
use App\Repositories\Interfaces\User\UserRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\User\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService implements UserServiceInterface
{
    protected $userRepository;
    public function __construct(
        UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }
    public function paginate()
    {
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['searchFields'] = ['fullname', 'email', 'phone', 'address'];
        $condition['publish'] = request('publish');

        $users = $this->userRepository->pagination(
            ['id', 'fullname', 'email', 'phone', 'address', 'publish', 'user_catalogue_id'],
            $condition,
            request('pageSize'),
            ['id' => 'desc'],
            [],
            ['user_catalogue']
        );

        foreach ($users as $key => $userCatalogue) {
            $userCatalogue->key = $userCatalogue->id;
        }

        return [
            'status' => 'success',
            'messages' => '',
            'data' => $users
        ];
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');
            $payload['password'] = Hash::make($payload['password']);
            $payload['user_agent'] = request()->header('User-Agent');
            $payload['ip'] = request()->ip();
            $payload['email_verified_at'] = now()->toDateTimeString();

            $this->userRepository->create($payload);
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
            $this->userRepository->update($id, $payload);

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
            $this->userRepository->delete($id);
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
