<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Cart\CartController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\Brand\BrandController;
use App\Http\Controllers\Api\V1\Widget\WidgetController;
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\Api\V1\Upload\{UploadController};
use App\Http\Controllers\Api\V1\Auth\VerificationController;
use App\Http\Controllers\Api\V1\User\UserCatalogueController;
use App\Http\Controllers\Api\V1\Attribute\AttributeController;
use App\Http\Controllers\Api\V1\Location\{LocationController};
use App\Http\Controllers\Api\V1\Permission\PermissionController;
use App\Http\Controllers\Api\V1\Attribute\AttributeValueController;
use App\Http\Controllers\Api\V1\Product\ProductCatalogueController;
use App\Http\Controllers\Api\V1\SystemConfig\SystemConfigController;
use App\Http\Controllers\Api\V1\PaymentMethod\PaymentMethodController;
use App\Http\Controllers\Api\V1\ShippingMethod\ShippingMethodController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('log.request.response')->group(function () {

    // CLIENT ROUTE
    Route::get('products/catalogues/list', [ProductCatalogueController::class, 'list']);
    Route::get('getWidget', [WidgetController::class, 'getWidget']);
    Route::get('getProduct/{slug}', [ProductController::class, 'getProduct']);

    // AUTH ROUTE
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
    Route::get('/email-register-verify/{id}', [VerificationController::class, 'emailRegisterVerify'])->name('email.register.verify');

    // LOCATION ROUTE
    Route::prefix('location')->group(function () {
        Route::get('provinces', [LocationController::class, 'getProvinces']);
        Route::get('getLocation', [LocationController::class, 'getLocation']);
    });

    // Routes with JWT Middleware
    Route::group(['middleware' => 'jwt.verify'], function () {

        // AUTH
        Route::get('auth/me', [AuthController::class, 'me']);
        Route::post('auth/refreshToken', [AuthController::class, 'refreshToken']);

        // DASHBOARD ROUTE
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::put('changeStatus', [DashboardController::class, 'changeStatus'])->name('changeStatus');
            Route::put('changeStatusMultiple', [DashboardController::class, 'changeStatusMultiple'])->name('changeStatusMultiple');
            Route::delete('deleteMultiple', [DashboardController::class, 'deleteMultiple'])->name('deleteMultiple');
            Route::get('getDataByModel', [DashboardController::class, 'getDataByModel'])->name('getDataByModel');
        });

        // USER ROUTE
        // * Neu dung resource de tao .../catalogues thi phai gan them name neu khong se bi loi
        Route::prefix('/')->name('users.')->group(function () {
            Route::apiResource('users/catalogues', UserCatalogueController::class);
        });
        Route::apiResource('users', UserController::class);

        // PERMISSION ROUTE
        Route::put('users/catalogues/permissions/{id}', [UserCatalogueController::class, 'updatePermissions'])->name('users.catalogues.permissions');
        Route::apiResource('permissions', PermissionController::class);

        // PRODUCT ROUTE
        Route::prefix('/')->name('products.')->group(function () {
            Route::apiResource('products/catalogues', ProductCatalogueController::class);
        });
        Route::get('products/variants', [ProductController::class, 'getProductVariants']);
        Route::put('products/variants/update', [ProductController::class, 'updateVariant']);
        Route::delete('products/variants/delete/{id}', [ProductController::class, 'deleteVariant']);
        Route::put('products/attributes/update/{productId}', [ProductController::class, 'updateAttribute']);
        Route::apiResource('products', ProductController::class);

        // ATTRIBUTE ROUTE
        Route::prefix('/')->name('attributes.')->group(function () {
            Route::apiResource('attributes/values', AttributeValueController::class);
        });
        Route::apiResource('attributes', AttributeController::class);

        // BRAND ROUTE
        Route::apiResource('brands', BrandController::class);

        // UPLOAD ROUTE
        Route::apiResource('uploads', UploadController::class);

        // SHIPPING METHOD ROUTE
        Route::apiResource('shipping-methods', ShippingMethodController::class);

        // PAYMENT METHOD ROUTE
        Route::apiResource('payment-methods', PaymentMethodController::class);

        // SYSTEM CONFIG ROUTE
        Route::get('system-configs', [SystemConfigController::class, 'index']);
        Route::put('system-configs', [SystemConfigController::class, 'update']);

        // CART ROUTE
        Route::controller(CartController::class)->name('cart.')->group(function () {
            Route::get('carts', 'index')->name('index');
            Route::post('carts', 'createOrUpdate')->name('store-or-update');
            Route::delete('carts/{id}/destroy', 'destroy')->name('destroy');
            Route::delete('carts/clear', 'forceDestroy')->name('force-destroy');
            Route::put('carts/handle-selected', 'handleSelected')->name('handle-selected');
        });


        // WIDGET ROUTE
        Route::apiResource('widgets', WidgetController::class);
    });
});
