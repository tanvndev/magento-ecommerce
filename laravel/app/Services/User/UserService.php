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
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
            'searchFields' => ['fullname', 'email', 'phone', 'address'],
        ];

        $select = ['id', 'fullname', 'email', 'phone', 'address', 'publish', 'user_catalogue_id'];
        $pageSize = request('pageSize');

        $data = $pageSize && request('page')
            ? $this->userRepository->pagination($select, $condition, $pageSize, [], [], ['user_catalogue'])
            : $this->userRepository->all($select);

        // Add key for table for frontend
        $data->transform(function ($item) {
            $item->key = $item->id;
            return $item;
        });

        return successResponse('', $data);
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = request()->except('_token', '_method');
            $payload = $this->formatPayload($payload);

            $this->userRepository->create($payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }

    private function formatPayload(array $payload): array
    {
        $payload = [
            'password' => Hash::make($payload['password']),
            'user_agent' => request()->header('User-Agent'),
            'ip' => request()->ip(),
            'email_verified_at' => now()->toDateTimeString(),
        ];

        return $payload;
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = request()->except('_token', '_method');
            $this->userRepository->update($id, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->userRepository->delete($id);
            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại.');
    }
}
