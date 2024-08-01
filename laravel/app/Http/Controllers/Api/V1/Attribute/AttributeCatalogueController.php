<?php

namespace App\Http\Controllers\Api\V1\Attribute;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\{
    StoreAttributeCatalogueRequest,
    UpdateAttributeCatalogueRequest
};
use App\Http\Resources\Attribute\AttributeCatalogueResource;
use App\Repositories\Interfaces\Attribute\AttributeCatalogueRepositoryInterface;
use App\Services\Interfaces\Attribute\AttributeCatalogueServiceInterface;

class AttributeCatalogueController extends Controller
{
    protected $productCatalogueService;
    protected $productCatalogueRepository;
    public function __construct(
        AttributeCatalogueServiceInterface $productCatalogueService,
        AttributeCatalogueRepositoryInterface $productCatalogueRepository
    ) {
        $this->productCatalogueService = $productCatalogueService;
        $this->productCatalogueRepository = $productCatalogueRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->productCatalogueService->paginate();
        return handleResponse($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeCatalogueRequest $request)
    {
        $response = $this->productCatalogueService->create();
        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = new AttributeCatalogueResource($this->productCatalogueRepository->findById($id));
        return successResponse('', $response);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeCatalogueRequest $request, string $id)
    {
        $response = $this->productCatalogueService->update($id);
        return handleResponse($response);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->productCatalogueService->destroy($id);
        return handleResponse($response);
    }
}
