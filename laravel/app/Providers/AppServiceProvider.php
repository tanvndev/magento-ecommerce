<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

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
        // AttributeValue
        'App\Services\Interfaces\Attribute\AttributeValueServiceInterface' => 'App\Services\Attribute\AttributeValueService',
        // Attribute
        'App\Services\Interfaces\Attribute\AttributeServiceInterface' => 'App\Services\Attribute\AttributeService',
        // Brand
        'App\Services\Interfaces\Brand\BrandServiceInterface' => 'App\Services\Brand\BrandService',
        // ShippingMethod
        'App\Services\Interfaces\ShippingMethod\ShippingMethodServiceInterface' => 'App\Services\ShippingMethod\ShippingMethodService',
        // SystemConfig
        'App\Services\Interfaces\SystemConfig\SystemConfigServiceInterface' => 'App\Services\SystemConfig\SystemConfigService',
        // PaymentMethod
        'App\Services\Interfaces\PaymentMethod\PaymentMethodServiceInterface' => 'App\Services\PaymentMethod\PaymentMethodService',
        // Cart
        'App\Services\Interfaces\Cart\CartServiceInterface' => 'App\Services\Cart\CartService',
        // Widget
        'App\Services\Interfaces\Widget\WidgetServiceInterface' => 'App\Services\Widget\WidgetService',
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
                'cache' => $fileSystem->getDriver(),
                'source_path_prefix' => env('IMAGE_SOURCE_PATH'),
                'cache_path_prefix' => '.cache',
            ]);
        });

        // $this->printLogSql();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}

    private function printLogSql()
    {
        DB::listen(function ($query) {
            $logPath = storage_path('logs/sql/' . Carbon::now()->format('Y-m-d') . '-slow-log.sql');

            $sqlWithBindings = $this->interpolateQuery($query->sql, $query->bindings);

            $logContent = sprintf(
                "/*==================================================================*/\n" .
                    "/* Origin (request): %s\n" .
                    "   Query %d - %s [%sms] */\n\n" .
                    "%s\n\n",
                request()->fullUrl() ?? 'N/A',
                $query->time, // Số thứ tự truy vấn
                Carbon::now()->toDateTimeString(),
                number_format($query->time, 2), // Thời gian thực thi
                $sqlWithBindings
            );

            File::append($logPath, $logContent);
        });
    }

    private function interpolateQuery($sql, $bindings)
    {
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'$binding'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }
}
