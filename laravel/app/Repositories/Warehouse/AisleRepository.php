<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Warehouse;

use App\Models\Aisle;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Warehouse\AisleRepositoryInterface;

class AisleRepository extends BaseRepository implements AisleRepositoryInterface
{
    protected $model;
    public function __construct(
        Aisle $model
    ) {
        $this->model = $model;
    }
}
