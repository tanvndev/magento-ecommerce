<?php



// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\Voucher;

use App\Models\Voucher;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Voucher\VoucherRepositoryInterface;

class VoucherRepository extends BaseRepository implements VoucherRepositoryInterface
{
    protected $model;

    public function __construct(
        Voucher $model
    ) {
        $this->model = $model;
    }
}
