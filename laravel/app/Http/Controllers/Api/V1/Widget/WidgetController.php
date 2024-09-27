<?php

namespace App\Http\Controllers\Api\V1\Widget;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Widget\StoreWidgetRequest;
use App\Http\Requests\Widget\UpdateWidgetRequest;
use App\Http\Resources\Widget\Client\ClientWidgetCollection;
use App\Http\Resources\Widget\WidgetCollection;
use App\Http\Resources\Widget\WidgetResource;
use App\Repositories\Interfaces\Widget\WidgetRepositoryInterface;
use App\Services\Interfaces\Widget\WidgetServiceInterface;
use Illuminate\Http\JsonResponse;

class WidgetController extends Controller
{
    protected $widgetService;

    protected $widgetRepository;

    public function __construct(
        WidgetServiceInterface $widgetService,
        WidgetRepositoryInterface $widgetRepository
    ) {
        $this->widgetService = $widgetService;
        $this->widgetRepository = $widgetRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginator = $this->widgetService->paginate();
        $data = new WidgetCollection($paginator);

        return successResponse('', $data, true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Widget\StoreWidgetRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreWidgetRequest $request): JsonResponse
    {
        $response = $this->widgetService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $widget = new WidgetResource($this->widgetRepository->findById($id));

        return successResponse('', $widget, true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Widget\UpdateWidgetRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateWidgetRequest $request, string $id): JsonResponse
    {
        $response = $this->widgetService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $response = $this->widgetService->destroy($id);

        return handleResponse($response);
    }

    // CLIENT API //

    /**
     * Get a widget by its code.
     *
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWidget(string $code): JsonResponse
    {
        $response = $this->widgetService->getWidgetByCode($code);

        $data = new ClientWidgetCollection($response);

        return successResponse('', $data, true);
    }

    /**
     * Get all widget codes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllWidgetCode(): JsonResponse
    {
        $response = $this->widgetService->getAllWidgetCode();

        return successResponse('', $response, true);
    }
}
