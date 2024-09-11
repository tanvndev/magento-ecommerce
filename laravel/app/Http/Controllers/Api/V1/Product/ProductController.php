<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductAttributeRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Product\UpdateProductVariantRequest;
use App\Http\Resources\Product\Client\ClientProductResource;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductVariantCollection;
use App\Repositories\Interfaces\Product\ProductRepositoryInterface;
use App\Services\Interfaces\Product\ProductServiceInterface;

class ProductController extends Controller
{
    protected $productService;

    protected $productRepository;

    public function __construct(
        ProductServiceInterface $productService,
        ProductRepositoryInterface $productRepository
    ) {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = $this->productService->paginate();
        $data = new ProductCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // dd($request->all());
        $response = $this->productService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = new ProductResource(
            $this->productRepository->findById($id)
        );

        return successResponse('', $response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $response = $this->productService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->productService->destroy($id);

        return handleResponse($response);
    }

    public function getProductVariants()
    {
        $paginator = $this->productService->getProductVariants();
        $data = new ProductVariantCollection($paginator);

        return successResponse('', $data);
    }

    public function updateVariant(UpdateProductVariantRequest $request)
    {
        $response = $this->productService->updateVariant();

        return handleResponse($response);
    }

    public function deleteVariant(string $id)
    {
        $response = $this->productService->deleteVariant($id);

        return handleResponse($response);
    }

    public function updateAttribute(UpdateProductAttributeRequest $request, string $productId)
    {
        $response = $this->productService->updateAttribute($productId);

        return handleResponse($response);
    }


    // CLIENT API //

    public function getProduct(string $slug)
    {
        $response = new ClientProductResource(
            $this->productService->getProduct($slug)
        );

        return successResponse('', $response);
    }
}
