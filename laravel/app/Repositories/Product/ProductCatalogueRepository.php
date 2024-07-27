<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Product;

use App\Models\ProductCatalogue;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Product\ProductCatalogueRepositoryInterface;

class ProductCatalogueRepository extends BaseRepository implements ProductCatalogueRepositoryInterface
{
    protected $model;
    public function __construct(
        ProductCatalogue $model
    ) {
        $this->model = $model;
    }
}
