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
use Illuminate\Http\JsonResponse;

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
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginator = $this->productService->paginate();
        $data = new ProductCollection($paginator);

        return successResponse('', $data, true);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param \App\Http\Requests\Product\StoreProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $response = $this->productService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified product.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $response = new ProductResource(
            $this->productRepository->findById($id)
        );

        return successResponse('', $response, true);
    }

    /**
     * Update the specified product in storage.
     *
     * @param \App\Http\Requests\Product\UpdateProductRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, string $id): JsonResponse
    {
        $response = $this->productService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $response = $this->productService->destroy($id);

        return handleResponse($response);
    }

    /**
     * Get all product variants.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductVariants(): JsonResponse
    {
        $paginator = $this->productService->getProductVariants();
        $data = new ProductVariantCollection($paginator);

        return successResponse('', $data, true);
    }

    /**
     * Update a specific product variant.
     *
     * @param \App\Http\Requests\Product\UpdateProductVariantRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateVariant(UpdateProductVariantRequest $request): JsonResponse
    {
        $response = $this->productService->updateVariant();

        return handleResponse($response);
    }

    /**
     * Delete a specific product variant.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteVariant(string $id): JsonResponse
    {
        $response = $this->productService->deleteVariant($id);

        return handleResponse($response);
    }

    /**
     * Update attributes for a specific product.
     *
     * @param \App\Http\Requests\Product\UpdateProductAttributeRequest $request
     * @param string $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAttribute(UpdateProductAttributeRequest $request, string $productId): JsonResponse
    {
        $response = $this->productService->updateAttribute($productId);

        return handleResponse($response);
    }

    // CLIENT API //

    /**
     * Get a specific product by its slug.
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProduct(string $slug): JsonResponse
    {
        $response = new ClientProductResource(
            $this->productService->getProduct($slug)
        );

        return successResponse('', $response, true);
    }
}
