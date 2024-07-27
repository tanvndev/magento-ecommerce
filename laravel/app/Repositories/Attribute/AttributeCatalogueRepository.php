<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Attribute;

use App\Models\AttributeCatalogue;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Attribute\AttributeCatalogueRepositoryInterface;

class AttributeCatalogueRepository extends BaseRepository implements AttributeCatalogueRepositoryInterface
{
    protected $model;
    public function __construct(
        AttributeCatalogue $model
    ) {
        $this->model = $model;
    }
}
