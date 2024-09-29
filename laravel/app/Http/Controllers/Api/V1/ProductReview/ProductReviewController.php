<?php

namespace App\Http\Controllers\Api\V1\ProductReview;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProductReview\ProductReviewService;
use App\Repositories\ProductReview\ProductReviewRepository;

class ProductReviewController extends Controller
{
    protected $productReviewService;
    protected $productReviewRepository;

    public function __construct(
        ProductReviewService $productReviewService,

        ProductReviewRepository $productReviewRepository
    ) {
        $this->productReviewService = $productReviewService;
        $this->productReviewRepository = $productReviewRepository;
    }
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $response = $this->productReviewService->createReview($request->all());

        return successResponse(__('messages.create.success'), $response);
    }
}
