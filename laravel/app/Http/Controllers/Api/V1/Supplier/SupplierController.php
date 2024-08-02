<?php

namespace App\Http\Controllers\Api\V1\Supplier;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\{
    StoreSupplierRequest,
    UpdateSupplierRequest
};
use App\Http\Resources\Supplier\SupplierCollection;
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
        $paginator = $this->supplierService->paginate();
        $data = new SupplierCollection($paginator);
        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $response = $this->supplierService->create();
        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = new SupplierResource($this->supplierRepository->findById($id));
        return successResponse('', $response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, string $id)
    {
        $response = $this->supplierService->update($id);
        return handleResponse($response);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->supplierService->destroy($id);
        return handleResponse($response);
    }
}
