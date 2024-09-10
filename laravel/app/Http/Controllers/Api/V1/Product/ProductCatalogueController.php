<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductCatalogueRequest;
use App\Http\Requests\Product\UpdateProductCatalogueRequest;
use App\Http\Resources\Product\ProductCatalogueCollection;
use App\Http\Resources\Product\ProductCatalogueResource;
use App\Repositories\Interfaces\Product\ProductCatalogueRepositoryInterface;
use App\Services\Interfaces\Product\ProductCatalogueServiceInterface;

class ProductCatalogueController extends Controller
{
    protected $productCatalogueService;

    protected $productCatalogueRepository;

    public function __construct(
        ProductCatalogueServiceInterface $productCatalogueService,
        ProductCatalogueRepositoryInterface $productCatalogueRepository
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

        return successResponse('', $response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCatalogueRequest $request)
    {
        $response = $this->productCatalogueService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = new ProductCatalogueResource($this->productCatalogueRepository->findById($id));

        return successResponse('', $response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCatalogueRequest $request, string $id)
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

    // CLIENT API //

    public function list()
    {
        $paginator = $this->productCatalogueService->list();
        $data = new ProductCatalogueCollection($paginator);

        return successResponse('', $data);
    }
}
