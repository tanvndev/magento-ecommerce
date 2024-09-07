<?php

namespace App\Http\Controllers\Api\V1\SystemConfig;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
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
        $data = $this->systemConfigService->all();

        return successResponse('', $data);
    }

    public function update()
    {
        $response = $this->systemConfigService->update();

        return handleResponse($response, ResponseEnum::CREATED);
    }
}
