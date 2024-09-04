<?php

namespace App\Http\Controllers\Api\V1\SystemConfig;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SystemConfig\{
    UpdateSystemConfigRequest
};
use App\Http\Resources\SystemConfig\SystemConfigCollection;
use App\Http\Resources\SystemConfig\SystemConfigResource;
use App\Repositories\Interfaces\SystemConfig\SystemConfigRepositoryInterface;
use App\Services\Interfaces\SystemConfig\SystemConfigServiceInterface;

class SystemConfigController extends Controller
{
    protected $systemConfigRepository;

    protected $systemConfigService;

    public function __construct(
        SystemConfigRepositoryInterface $systemConfigRepository,
        SystemConfigServiceInterface $systemConfigService
    ) {
        $this->systemConfigRepository = $systemConfigRepository;
        $this->systemConfigService = $systemConfigService;
    }

    public function index()
    {
        $systemConfig = $this->systemConfigService->all();
        $data = new SystemConfigCollection($systemConfig);

        return successResponse('', $data);
    }

    public function show(string $id)
    {
        $systemConfig = new SystemConfigResource($this->systemConfigRepository->findById($id));

        return successResponse('', $systemConfig);
    }

    public function update(UpdateSystemConfigRequest $request, $id)
    {
        $response = $this->systemConfigService->update($id);

        return handleResponse($response, ResponseEnum::CREATED);
    }
}
