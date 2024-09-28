<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\User;

use App\Models\User;
use App\Repositories\Interfaces\User\UserCatalogueRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\User\UserCatalogueServiceInterface;
use Exception;

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
        $request = request();

        $condition = [
            'search'  => addslashes($request->search),
            'publish' => $request->publish,
            'archive' => $request->boolean('archive'),
        ];
        $select = ['id', 'name', 'description', 'publish', 'code'];
        $pageSize = $request->pageSize;

        $data = $pageSize && $request->page
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

            $this->checkUserInCatalogue($id);

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

    public function handleArchiveMultiple()
    {
        return $this->executeInTransaction(function () {
            $request = request();

            $this->userCatalogueRepository->restoreByWhereIn('id', $request->modelIds);

            return successResponse(__('messages.action.success'));
        }, __('messages.action.error'));
    }

    public function deleteMultiple()
    {
        return $this->executeInTransaction(function () {
            $request = request();

            $this->checkUserInCatalogues($request->modelIds);

            $forceDelete = ($request->has('forceDelete') && $request->forceDelete == '1')
                ? 'forceDeleteByWhereIn'
                : 'deleteByWhereIn';

            $this->userCatalogueRepository->{$forceDelete}('id', $request->modelIds);

            return successResponse(__('messages.action.success'));
        }, __('messages.action.error'));
    }

    public function updateStatus()
    {
        return $this->executeInTransaction(function () {
            $request = request();

            $this->checkUserInCatalogue($request->value);

            $payload[$request->field] = $request->value;

            $this->userCatalogueRepository->update($request->id, $payload);

            return successResponse(__('messages.publish.success'));
        }, __('messages.publish.error'));
    }

    public function updateStatusMultiple()
    {
        return $this->executeInTransaction(function () {
            $request = request();

            $this->checkUserInCatalogues($request->modelIds);

            $payload[$request->field] = $request->value;

            $this->userCatalogueRepository->updateByWhereIn('id', $request->modelIds, $payload);

            return successResponse(__('messages.publish.success'));
        }, __('messages.publish.error'));
    }

    private function checkUserInCatalogue($id)
    {
        $catalogues = $this->userCatalogueRepository->findById($id, ['users']);

        if ($catalogues->users->count() > 0) {
            throw new Exception(__('messages.delete.error'));
        }

        if ($id == User::ROLE_ADMIN || $id == User::ROLE_CUSTOMER) {
            throw new Exception(__('messages.delete.error'));
        }
    }

    private function checkUserInCatalogues($ids)
    {
        $catalogues = $this->userCatalogueRepository->findByWhereIn($ids, 'id', ['users']);

        if ($catalogues->users->count() > 0) {
            throw new Exception(__('messages.delete.error'));
        }

        if (in_array(User::ROLE_ADMIN, $ids) || in_array(User::ROLE_CUSTOMER, $ids)) {
            throw new Exception(__('messages.delete.error'));
        }
    }
}
