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

            $this->removeIsPrimary();

            $this->userAddressRepository->create($payload);

            return successResponse(__('messages.userAddress.success.create'));
        }, __('messages.userAddress.error.create'));
    }

    /**
     * Prepare the payload for creating a new user address.
     *
     * This method takes the request payload, adds the current user ID to it if the user is authenticated,
     * and sets is_primary to 0 if it is not provided.
     */
    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');

        $payload['user_id'] = auth()->user()->id;
        $payload['is_primary'] = $payload['is_primary'] ?? true;

        return $payload;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->userAddressRepository->delete($id);

            return successResponse(__('messages.userAddress.success.delete'));
        }, __('messages.userAddress.error.delete'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();

            if ($payload['is_primary']) {
                $this->removeIsPrimary();
            }

            $this->userAddressRepository->update($id, $payload);

            return successResponse(__('messages.userAddress.success.update'));
        }, __('messages.userAddress.success.error'));
    }

    private function removeIsPrimary(): void
    {
        $this->userAddressRepository->updateByWhere(
            [
                'user_id'    => auth()->user()->id,
                'is_primary' => 1,
            ],
            ['is_primary' => 0]
        );
    }

    /**
     * Get user addresses by user ID.
     *
     * @return \Illuminate\Support\Collection
     */
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
