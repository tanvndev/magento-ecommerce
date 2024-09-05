<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Cart\CartRepositoryInterface;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    protected $model;

    public function __construct(
        Cart $model
    ) {
        $this->model = $model;
    }
}
