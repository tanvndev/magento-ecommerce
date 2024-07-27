<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\User;

use App\Models\UserCatalogue;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\User\UserCatalogueRepositoryInterface;

class UserCatalogueRepository extends BaseRepository implements UserCatalogueRepositoryInterface
{
    protected $model;
    public function __construct(
        UserCatalogue $model
    ) {
        $this->model = $model;
    }
}
