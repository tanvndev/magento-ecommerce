<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Permission;

use App\Repositories\Interfaces\Permission\PermissionRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Permission\PermissionServiceInterface;

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
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
            'searchFields' => ['canonical'],
        ];

        $select = ['id', 'name', 'canonical'];
        $pageSize = request('pageSize');

        $data = $pageSize && request('page')
            ? $this->permissionRepository->pagination($select, $condition, $pageSize)
            : $this->permissionRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = request()->except('_token', '_method');

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

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = request()->except('_token', '_method');
            $this->permissionRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->permissionRepository->delete($id);

            return successResponse(__('messages.delete.success'));
        }, __('messages.delete.error'));
    }
}
