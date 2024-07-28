<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Tax;

use App\Models\Tax;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Tax\TaxRepositoryInterface;

class TaxRepository extends BaseRepository implements TaxRepositoryInterface
{
    protected $model;
    public function __construct(
        Tax $model
    ) {
        $this->model = $model;
    }
}
