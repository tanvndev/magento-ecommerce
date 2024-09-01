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

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {

        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->systemConfigRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    public function destroy($id)
    {

        return $this->executeInTransaction(function () use ($id) {

            $this->systemConfigRepository->delete($id);
            return successResponse(__('messages.delete.success'));
        }, __('messages.delete.error'));
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');
        return $payload;
    }
}
