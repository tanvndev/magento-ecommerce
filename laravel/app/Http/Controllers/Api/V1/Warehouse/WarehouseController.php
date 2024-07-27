<?php

namespace App\Http\Controllers\Api\V1\Warehouse;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Warehouse\{
    StoreWarehouseRequest,
    UpdateWarehouseRequest
};
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
        $response = $this->warehouseService->paginate();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseRequest $request)
    {
        $response = $this->warehouseService->create();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::CREATED : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $warehouse = new WarehouseResource($this->warehouseRepository->findById($id));
        return response()->json([
            'status' => 'success',
            'messages' => '',
            'data' => $warehouse ?? []
        ], ResponseEnum::OK);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, string $id)
    {
        $response = $this->warehouseService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->warehouseService->destroy($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
}
