<?php

namespace App\Services\SystemConfig;

use App\Repositories\Interfaces\SystemConfig\SystemConfigRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\SystemConfig\SystemConfigServiceInterface;

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

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->systemConfigRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');
        $payload['user_id'] = auth()->user()->id;

        return $payload;
    }
}
