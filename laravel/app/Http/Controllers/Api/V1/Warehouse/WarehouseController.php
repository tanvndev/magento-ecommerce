<?php

namespace App\Http\Controllers\Api\V1\Warehouse;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Warehouse\{
    StoreWarehouseRequest,
    UpdateWarehouseRequest
};
use App\Http\Resources\Warehouse\WarehouseCollection;
use App\Http\Resources\Warehouse\WarehouseResource;
use App\Repositories\Interfaces\Warehouse\WarehouseRepositoryInterface;
use App\Services\Interfaces\Warehouse\WarehouseServiceInterface;

class WarehouseController extends Controller
{
    protected $warehouseService;
    protected $warehouseRepository;
    public function __construct(
        WarehouseServiceInterface $warehouseService,
        WarehouseRepositoryInterface $warehouseRepository
    ) {
        $this->warehouseService = $warehouseService;
        $this->warehouseRepository = $warehouseRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = $this->warehouseService->paginate();
        $data = new WarehouseCollection($paginator);
        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseRequest $request)
    {
        $response = $this->warehouseService->create();
        dd($response);
        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = new WarehouseResource($this->warehouseRepository->findById($id));
        return successResponse('', $response);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, string $id)
    {
        $response = $this->warehouseService->update($id);
        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->warehouseService->destroy($id);
        return handleResponse($response);
    }
}
