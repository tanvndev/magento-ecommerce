<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories\User;

use App\Models\UserAddress;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\User\UserAddressRepositoryInterface;

class UserAddressRepository extends BaseRepository implements UserAddressRepositoryInterface
{
    protected $model;

    public function __construct(
        UserAddress $model
    ) {
        $this->model = $model;
    }
}
