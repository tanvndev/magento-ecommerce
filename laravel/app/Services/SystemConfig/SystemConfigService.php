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
        $data = $this->systemConfigRepository->all();

        $result = $data->mapWithKeys(function ($item) {
            return [$item->code => $item->content];
        });

        return $result;
    }

    public function update()
    {
        return $this->executeInTransaction(function () {

            $payload = request()->except('_token', '_method');

            foreach ($payload as $key => $value) {
                $payload = [
                    'code' => $key,
                    'content' => $value,
                    'user_id' => auth()->user()->id,
                ];
                $condition = ['code' => $key];
                $this->systemConfigRepository->updateOrCreate($payload, $condition);
            }

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }
}
