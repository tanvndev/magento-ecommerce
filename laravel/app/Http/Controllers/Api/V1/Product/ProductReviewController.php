<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductReviewCollection;
use App\Http\Requests\Product\StoreProductReviewRequest;
use App\Http\Resources\Product\Client\ClientProductReviewCollection;
use App\Services\Interfaces\Product\ProductReviewServiceInterface;
use App\Repositories\Interfaces\Product\ProductReviewRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ProductReviewController extends Controller
{
    protected $productReviewService;
    protected $productReviewRepository;

    public function __construct(
        ProductReviewServiceInterface $productReviewService,

        ProductReviewRepositoryInterface $productReviewRepository
    ) {
        $this->productReviewService = $productReviewService;
        $this->productReviewRepository = $productReviewRepository;
    }
    /**
     * Get all reviews for a product by product id
     *
     * @param string $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReviewByProductId(string $productId): JsonResponse
    {

        $productReviews = $this->productReviewService->getReviewByProductId($productId);

        $data = new ClientProductReviewCollection($productReviews);

        return successResponse('', $data, true);
    }

    /**
     * Get all product reviews
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllProductReviews(): JsonResponse
    {

        $productReviews = $this->productReviewService->getAllProductReviews();

        $data = new ProductReviewCollection($productReviews);

        return successResponse('', $data, true);
    }

    /**
     * Create a new product review.
     *
     * @param StoreProductReviewRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductReviewRequest $request): JsonResponse
    {
        $response = $this->productReviewService->createReview($request->all());

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Admin reply a product review.
     *
     * @param StoreProductReviewRequest $request
     * @param string $parentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminReply(StoreProductReviewRequest $request, string $parentId): JsonResponse
    {
        $response = $this->productReviewService->adminReply($request->all(), $parentId);

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Update a reply product review as admin.
     *
     * @param StoreProductReviewRequest $request
     * @param string $replyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminUpdateReply(StoreProductReviewRequest $request, string $replyId): JsonResponse
    {
        $response = $this->productReviewService->adminUpdateReply($request->all(), $replyId);

        return handleResponse($response, ResponseEnum::CREATED);
    }
}
