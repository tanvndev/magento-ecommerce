<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\User;

use App\Repositories\Interfaces\User\UserCatalogueRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\User\UserCatalogueServiceInterface;

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
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
        ];
        $select = ['id', 'name', 'description', 'publish', 'code'];
        $pageSize = request('pageSize');

        $data = $pageSize && request('page')
            ? $this->userCatalogueRepository->pagination(
                $select,
                $condition,
                $pageSize,
                [],
                [],
                ['users']
            )
            : $this->userCatalogueRepository->all($select, ['permissions']);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = request()->except('_token', '_method');
            $this->userCatalogueRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = request()->except('_token', '_method');
            $this->userCatalogueRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->userCatalogueRepository->delete($id);

            return successResponse(__('messages.delete.success'));
        }, __('messages.delete.error'));
    }

    public function updatePermissions()
    {
        return $this->executeInTransaction(function () {
            $permissions = json_decode(request('permissions'), true);
            $catalogueIds = array_keys($permissions);

            $userCatalogues = $this->userCatalogueRepository->findByWhereIn($catalogueIds);

            foreach ($userCatalogues as $userCatalogue) {
                $permissionIds = $permissions[$userCatalogue->id] ?? [];
                $userCatalogue->permissions()->sync($permissionIds);
            }

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }
}
