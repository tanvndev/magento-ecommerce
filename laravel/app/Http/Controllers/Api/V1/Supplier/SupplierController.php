<?php

namespace App\Http\Controllers\Api\V1\Supplier;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\{
    StoreSupplierRequest,
    UpdateSupplierRequest
};
use App\Http\Resources\Supplier\SupplierResource;
use App\Repositories\Interfaces\Supplier\SupplierRepositoryInterface;
use App\Services\Interfaces\Supplier\SupplierServiceInterface;

class SupplierController extends Controller
{
    protected $supplierService;
    protected $supplierRepository;
    public function __construct(
        SupplierServiceInterface $supplierService,
        SupplierRepositoryInterface $supplierRepository
    ) {
        $this->supplierService = $supplierService;
        $this->supplierRepository = $supplierRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->supplierService->paginate();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $response = $this->supplierService->create();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::CREATED : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = new SupplierResource($this->supplierRepository->findById($id));
        return response()->json([
            'status' => 'success',
            'messages' => '',
            'data' => $supplier ?? []
        ], ResponseEnum::OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, string $id)
    {
        $response = $this->supplierService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    public function hanleUpdate(UpdateSupplierRequest $request, string $id)
    {
        $response = $this->supplierService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->supplierService->destroy($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
}
