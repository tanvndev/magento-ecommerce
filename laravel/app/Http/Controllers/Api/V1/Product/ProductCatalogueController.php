<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\{
    StoreProductCatalogueRequest,
    UpdateProductCatalogueRequest
};
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
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCatalogueRequest $request)
    {
        $response = $this->productCatalogueService->create();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::CREATED : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productCatalogue = new ProductCatalogueResource($this->productCatalogueRepository->findById($id));
        return response()->json([
            'status' => 'success',
            'messages' => '',
            'data' => $productCatalogue ?? []
        ], ResponseEnum::OK);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCatalogueRequest $request, string $id)
    {
        $response = $this->productCatalogueService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    public function hanleUpdate(UpdateProductCatalogueRequest $request, string $id)
    {
        $response = $this->productCatalogueService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->productCatalogueService->destroy($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
}
