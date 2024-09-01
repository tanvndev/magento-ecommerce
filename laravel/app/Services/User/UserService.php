<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\User;

use App\Repositories\Interfaces\User\UserRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\User\UserServiceInterface;
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

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {
            $payload = request()->except('_token', '_method');
            $payload = $this->formatPayload($payload);

            $this->userRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
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

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->userRepository->delete($id);

            return successResponse(__('messages.delete.success'));
        }, __('messages.delete.error'));
    }
}
