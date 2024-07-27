<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Location;

use App\Models\District;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Location\DistrictRepositoryInterface;

class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface
{
    protected $model;
    public function __construct(
        District $model
    ) {
        $this->model = $model;
    }
}
