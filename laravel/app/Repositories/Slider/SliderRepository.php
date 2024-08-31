<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Slider;

use App\Models\Slider;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Slider\SliderRepositoryInterface;

class SliderRepository extends BaseRepository implements SliderRepositoryInterface
{
    protected $model;
    public function __construct(
        Slider $model
    ) {
        $this->model = $model;
    }
}
