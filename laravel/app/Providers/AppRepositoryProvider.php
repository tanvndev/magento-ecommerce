<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $repositoryBindings = [
        // Base
        'App\Repositories\Interfaces\BaseRepositoryInterface' => 'App\Repositories\BaseRepository',
        // User
        'App\Repositories\Interfaces\User\UserRepositoryInterface' => 'App\Repositories\User\UserRepository',
        // UserCatalogue
        'App\Repositories\Interfaces\User\UserCatalogueRepositoryInterface' => 'App\Repositories\User\UserCatalogueRepository',
        // Permission
        'App\Repositories\Interfaces\Permission\PermissionRepositoryInterface' => 'App\Repositories\Permission\PermissionRepository',
        // Province
        'App\Repositories\Interfaces\Location\ProvinceRepositoryInterface' => 'App\Repositories\Location\ProvinceRepository',
        // District
        'App\Repositories\Interfaces\Location\DistrictRepositoryInterface' => 'App\Repositories\Location\DistrictRepository',
        // ProductCatalogue
        'App\Repositories\Interfaces\Product\ProductCatalogueRepositoryInterface' => 'App\Repositories\Product\ProductCatalogueRepository',
        // Product
        'App\Repositories\Interfaces\Product\ProductRepositoryInterface' => 'App\Repositories\Product\ProductRepository',
        // AttributeCatalogue
        'App\Repositories\Interfaces\Attribute\AttributeCatalogueRepositoryInterface' => 'App\Repositories\Attribute\AttributeCatalogueRepository',
        // Attribute
        'App\Repositories\Interfaces\Attribute\AttributeRepositoryInterface' => 'App\Repositories\Attribute\AttributeRepository',
        // Warehouse
        'App\Repositories\Interfaces\Warehouse\WarehouseRepositoryInterface' => 'App\Repositories\Warehouse\WarehouseRepository',
        // Brand
        'App\Repositories\Interfaces\Brand\BrandRepositoryInterface' => 'App\Repositories\Brand\BrandRepository',
        // Supplier
        'App\Repositories\Interfaces\Supplier\SupplierRepositoryInterface' => 'App\Repositories\Supplier\SupplierRepository',

    ];

    public function register(): void
    {
        foreach ($this->repositoryBindings as $key => $value) {
            $this->app->bind($key, $value);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
