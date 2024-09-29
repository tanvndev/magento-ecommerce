<?php

namespace App\Services\Interfaces\Product;

interface ProductReviewServiceInterface
{

public function getReviewByProductId($productId);

public function getAllProductReviews();

public function createReview(array $data);

public function adminReply(array $data, $parentId);

public function adminUpdateReply(array $data, $replyId);


}
