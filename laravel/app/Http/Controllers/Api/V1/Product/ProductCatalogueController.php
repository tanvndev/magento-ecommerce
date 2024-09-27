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
use Illuminate\Http\JsonResponse;

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
     * Display a listing of the product catalogues.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = $this->productCatalogueService->paginate();

        return successResponse('', $response, true);
    }

    /**
     * Store a newly created product catalogue in storage.
     *
     * @param \App\Http\Requests\Product\StoreProductCatalogueRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductCatalogueRequest $request): JsonResponse
    {
        $response = $this->productCatalogueService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified product catalogue.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $response = new ProductCatalogueResource($this->productCatalogueRepository->findById($id));

        return successResponse('', $response, true);
    }

    /**
     * Update the specified product catalogue in storage.
     *
     * @param \App\Http\Requests\Product\UpdateProductCatalogueRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductCatalogueRequest $request, string $id): JsonResponse
    {
        $response = $this->productCatalogueService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified product catalogue from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $response = $this->productCatalogueService->destroy($id);

        return handleResponse($response);
    }

    /**
     * List all product catalogues for the client.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(): JsonResponse
    {
        $paginator = $this->productCatalogueService->list();
        $data = new ProductCatalogueCollection($paginator);

        return successResponse('', $data, true);
    }
}
