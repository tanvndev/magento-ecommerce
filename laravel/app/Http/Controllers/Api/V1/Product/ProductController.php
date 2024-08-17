<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
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
        $response = $this->productService->paginate();

        return handleResponse($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $response = $this->productService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = new ProductResource($this->productRepository->findById($id));

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
}
