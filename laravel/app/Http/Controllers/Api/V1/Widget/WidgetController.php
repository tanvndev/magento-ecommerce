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
     */
    public function index()
    {
        $paginator = $this->widgetService->paginate();
        $data = new WidgetCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWidgetRequest $request)
    {
        $response = $this->widgetService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $widget = new WidgetResource($this->widgetRepository->findById($id));

        return successResponse('', $widget);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWidgetRequest $request, string $id)
    {
        $response = $this->widgetService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->widgetService->destroy($id);

        return handleResponse($response);
    }

    // CLIENT API //

    public function getWidget()
    {
        $response = $this->widgetService->getWidget();

        $data = new ClientWidgetCollection($response);

        return successResponse('', $data);
    }
}
