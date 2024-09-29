<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductReviewCollection;
use App\Http\Requests\Product\StoreProductReviewRequest;
use App\Http\Resources\Product\Client\ClientProductReviewCollection;
use App\Services\Interfaces\Product\ProductReviewServiceInterface;
use App\Repositories\Interfaces\Product\ProductReviewRepositoryInterface;

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
    public function getReviewByProductId($productId)
    {

        $productReviews = $this->productReviewService->getReviewByProductId($productId);

        $data = new ClientProductReviewCollection($productReviews);

        return successResponse('', $data, true);
    }

    public function getAllProductReviews()
    {

        $productReviews = $this->productReviewService->getAllProductReviews();

        $data = new ProductReviewCollection($productReviews);

        return successResponse('', $data, true);
    }

    public function store(StoreProductReviewRequest $request)
    {
        $response = $this->productReviewService->createReview($request->all());

        return handleResponse($response, ResponseEnum::CREATED);
    }

    public function adminReply(StoreProductReviewRequest $request, $parentId)
    {
        $response = $this->productReviewService->adminReply($request->all(), $parentId);

        return handleResponse($response, ResponseEnum::CREATED);
    }

    public function adminupdateReply(StoreProductReviewRequest $request, $replyId)
    {
        $response = $this->productReviewService->adminUpdateReply($request->all(), $replyId);

        return handleResponse($response, ResponseEnum::CREATED);
    }
}
