<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\WishList;

use App\Models\WishList;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\WishList\WishListRepositoryInterface;

class WishListRepository extends BaseRepository implements WishListRepositoryInterface
{
    protected $model;

    public function __construct(
        WishList $model
    ) {
        $this->model = $model;
    }
}
