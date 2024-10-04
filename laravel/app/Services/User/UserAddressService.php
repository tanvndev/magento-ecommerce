<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\User;

use App\Repositories\Interfaces\User\UserAddressRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\User\UserAddressServiceInterface;

class UserAddressService extends BaseService implements UserAddressServiceInterface
{
    protected $userAddressRepository;

    public function __construct(
        UserAddressRepositoryInterface $userAddressRepository,
    ) {
        $this->userAddressRepository = $userAddressRepository;
    }

    public function paginate()
    {

        $select = ['id', 'user_id', 'province_code', 'district_code', 'ward_code', 'fullname', 'shipping_address', 'phone', 'is_primary'];

        $pageSize = request('pageSize');

        $data = $this->userAddressRepository->pagination(
            $select,
            [],
            $pageSize,
            [],
            [],
            ['province', 'district', 'ward'],
        );

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();

            if ( ! auth()->check()) {
                return errorResponse(__('messages.userAddress.error.auth'));
            } else {
                if ($payload['is_primary'] == 1) {
                    $this->userAddressRepository->updateByWhere(
                        ['user_id' => $payload['user_id'], 'is_primary' => 1],
                        ['is_primary' => 0]
                    );
                }
                $this->userAddressRepository->create($payload);

                return successResponse(__('messages.userAddress.success.create'));
            }

        }, __('messages.userAddress.error.create'));
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');

        if (auth()->check()) {
            $payload['user_id'] = auth()->user()->id;
            $payload['is_primary'] = $payload['is_primary'] ?? 0;
        } else {
            return [];
        }

        return $payload;
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->userAddressRepository->delete($id);

            return successResponse(__('messages.userAddress.success.delete'));
        }, __('messages.userAddress.error.delete'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();

            if ( ! auth()->check()) {
                return errorResponse(__('messages.userAddress.error.auth'));
            } else {
                if ($payload['is_primary']) {
                    $this->userAddressRepository->updateByWhere(
                        ['user_id' => $payload['user_id'], 'is_primary' => 1],
                        ['is_primary' => 0]
                    );
                }
                $this->userAddressRepository->update($id, $payload);
            }

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    public function getAddressByUserId()
    {
        $user = auth()->user();

        $user->userAddress = $this->userAddressRepository->findByWhere(
            ['user_id' => $user->id],
            ['*'],
            [],
            true
        );

        return $user->userAddress ?? collect();
    }
}
