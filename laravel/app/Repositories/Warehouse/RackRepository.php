<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Warehouse;

use App\Models\Rack;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Warehouse\RackRepositoryInterface;

class RackRepository extends BaseRepository implements RackRepositoryInterface
{
    protected $model;
    public function __construct(
        Rack $model
    ) {
        $this->model = $model;
    }
}
