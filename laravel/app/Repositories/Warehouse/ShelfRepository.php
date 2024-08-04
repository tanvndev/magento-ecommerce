<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Warehouse;

use App\Models\Shelf;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Warehouse\ShelfRepositoryInterface;

class ShelfRepository extends BaseRepository implements ShelfRepositoryInterface
{
    protected $model;
    public function __construct(
        Shelf $model
    ) {
        $this->model = $model;
    }
}
