<?php

namespace App\Http\Controllers\Api\V1\SystemConfig;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SystemConfig\{
    StoreSystemConfigRequest,
    UpdateSystemConfigRequest
};
use App\Http\Resources\SystemConfig\SystemConfigResource;
use App\Services\Interfaces\SystemConfig\SystemConfigServiceInterface;
use App\Repositories\Interfaces\SystemConfig\SystemConfigRepositoryInterface;


class SystemConfigController extends Controller
{
    protected $systemConfigRepository;

    protected $systemConfigService;


    public function __construct(
        SystemConfigRepositoryInterface     $systemConfigRepository,
        SystemConfigServiceInterface        $systemConfigService
    ) {
        $this->systemConfigRepository       = $systemConfigRepository;
        $this->systemConfigService          = $systemConfigService;
    }


    public function index()
    {
        return $this->systemConfigService->all();
    }


    public function store(StoreSystemConfigRequest $request)
    {
        $response = $this->systemConfigService->create();
        return handleResponse($response, ResponseEnum::CREATED);
    }


    public function show(string $id){
        $systemConfig = new SystemConfigResource($this->systemConfigRepository->findById($id));
        return successResponse('', $systemConfig);
    }


    public function update(UpdateSystemConfigRequest $request,$id)
    {
        $response = $this->systemConfigService->update($id);
        return handleResponse($response, ResponseEnum::CREATED);
    }


    public function destroy(string $id){
        $response = $this->systemConfigService->destroy($id);
        return handleResponse($response);
    }
}
