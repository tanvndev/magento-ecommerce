<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Post\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    protected $model;

    public function __construct(
        Post $model
    ) {
        $this->model = $model;
    }
}
