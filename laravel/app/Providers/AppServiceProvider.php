<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\ServerFactory;
use League\Glide\Responses\LaravelResponseFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    // Khai bao cac service
    protected $serviceBindings = [
        // Base
        'App\Services\Interfaces\BaseServiceInterface' => 'App\Services\BaseService',
        // User
        'App\Services\Interfaces\User\UserServiceInterface' => 'App\Services\User\UserService',
        // Auth
        'App\Services\Interfaces\Auth\AuthServiceInterface' => 'App\Services\Auth\AuthService',
        // UserCatalogue
        'App\Services\Interfaces\User\UserCatalogueServiceInterface' => 'App\Services\User\UserCatalogueService',
        // Permission
        'App\Services\Interfaces\Permission\PermissionServiceInterface' => 'App\Services\Permission\PermissionService',
        // Upload
        'App\Services\Interfaces\Upload\UploadServiceInterface' => 'App\Services\Upload\UploadService',
        // ProductCatalogue
        'App\Services\Interfaces\Product\ProductCatalogueServiceInterface' => 'App\Services\Product\ProductCatalogueService',
        // Product
        'App\Services\Interfaces\Product\ProductServiceInterface' => 'App\Services\Product\ProductService',
        // AttributeCatalogue
        'App\Services\Interfaces\Attribute\AttributeCatalogueServiceInterface' => 'App\Services\Attribute\AttributeCatalogueService',
        // Attribute
        'App\Services\Interfaces\Attribute\AttributeServiceInterface' => 'App\Services\Attribute\AttributeService',
        // Warehouse
        'App\Services\Interfaces\Warehouse\WarehouseServiceInterface' => 'App\Services\Warehouse\WarehouseService',

    ];
    public function register(): void
    {
        foreach ($this->serviceBindings as $key => $value) {
            $this->app->bind($key, $value);
        }

        $this->app->register(AppRepositoryProvider::class);

        // Register Glide server
        $this->app->singleton('League\Glide\Server', function ($app) {
            $fileSystem = $app->make(Filesystem::class);
            return ServerFactory::create([
                'response' => new LaravelResponseFactory(app('request')),
                'source' => $fileSystem->getDriver(),
                'cache' =>  $fileSystem->getDriver(),
                'source_path_prefix' => env('IMAGE_SOURCE_PATH'),
                'cache_path_prefix' => '.cache',
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
