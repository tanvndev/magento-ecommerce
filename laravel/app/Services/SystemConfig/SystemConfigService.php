<?php

namespace App\Services\SystemConfig;

use App\Services\BaseService;
use App\Services\Interfaces\SystemConfig\SystemConfigServiceInterface;
use App\Repositories\Interfaces\SystemConfig\SystemConfigRepositoryInterface;

class SystemConfigService extends BaseService implements SystemConfigServiceInterface
{

    protected $systemConfigRepository;

    public function __construct(
        SystemConfigRepositoryInterface $systemConfigRepository
    ) {
        $this->systemConfigRepository = $systemConfigRepository;
    }

    public function all()
    {

        return $this->systemConfigRepository->all();
    }

    public function create()
    {
        return $this->executeInTransaction(function () {
            $payload = $this->preparePayload();
            $this->systemConfigRepository->create($payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo thất bại!');
    }

    public function update($id)
    {

        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->systemConfigRepository->update($id, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhật thất bại!');
    }

    public function destroy($id)
    {

        return $this->executeInTransaction(function () use ($id) {

            $this->systemConfigRepository->delete($id);
            return successResponse('Xóa thành công!');
        }, 'Xóa thất bại!');
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');
        return $payload;
    }
}
