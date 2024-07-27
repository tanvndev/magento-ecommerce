<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Location;

use App\Models\Province;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Location\ProvinceRepositoryInterface;

class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{
    protected $model;
    public function __construct(
        Province $model
    ) {
        $this->model = $model;
    }
}
