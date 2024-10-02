<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestApiController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Cart\CartController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\Brand\BrandController;
use App\Http\Controllers\Api\V1\Order\OrderController;
use App\Http\Controllers\Api\V1\Slider\SliderController;
use App\Http\Controllers\Api\V1\Upload\UploadController;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\User\UserAddressController;
use App\Http\Controllers\Api\V1\WishList\WishListController;
use App\Http\Controllers\Api\V1\Widget\WidgetController;
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\Api\V1\Voucher\VoucherController;
use App\Http\Controllers\Api\V1\Auth\VerificationController;
use App\Http\Controllers\Api\V1\Location\LocationController;
use App\Http\Controllers\Api\V1\User\UserCatalogueController;
use App\Http\Controllers\Api\V1\Attribute\AttributeController;
use App\Http\Controllers\Api\V1\Permission\PermissionController;
use App\Http\Controllers\Api\V1\Attribute\AttributeValueController;
use App\Http\Controllers\Api\V1\Product\ProductCatalogueController;
use App\Http\Controllers\Api\V1\SystemConfig\SystemConfigController;
use App\Http\Controllers\Api\V1\PaymentMethod\PaymentMethodController;
use App\Http\Controllers\Api\V1\Product\ProductReviewController;
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

Route::middleware('log.request.response', 'api')->group(function () {

    // ROUTE TEST
    Route::post('test/index', [TestApiController::class, 'upload']);

    // CLIENT ROUTE
    Route::get('products/catalogues/list', [ProductCatalogueController::class, 'list']);
    Route::get('widgets/codes', [WidgetController::class, 'getAllWidgetCode']);
    Route::get('widgets/{code}/detail', [WidgetController::class, 'getWidget']);
    Route::get('products/{slug}/detail', [ProductController::class, 'getProduct']);
    Route::get('vouchers/all', [VoucherController::class, 'getAllVoucher']);
    Route::get('sliders/all', [SliderController::class, 'getAllSlider']);
    Route::get('payment-methods/all', [PaymentMethodController::class, 'getAllPaymentMethod']);
    Route::get('shipping-methods/products/{productVariantIds}', [ShippingMethodController::class, 'getShippingMethodByProductVariant']);
    Route::post('vouchers/{code}/apply', [VoucherController::class, 'applyVoucher']);
    Route::get('product-reviews', [ProductReviewController::class, 'getAllProductReviews'])->name('index');

    // Order
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/{orderCode}/detail', [OrderController::class, 'getOrder']);
    Route::get('orders/user', [OrderController::class, 'getOrderByUser']);
    Route::get('orders/{orderCode}/payment', [OrderController::class, 'handleOrderPayment']);
    Route::put('orders/{id}/complete', [OrderController::class, 'updateCompletedOrder']);
    Route::put('orders/{id}/cancel', [OrderController::class, 'updateCancelledOrder']);

    // AUTH ROUTE
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refreshToken', [AuthController::class, 'refreshToken']);
    });
    Route::get('/email-register-verify/{id}', [VerificationController::class, 'emailRegisterVerify'])->name('email.register.verify');

    // LOCATION ROUTE
    Route::prefix('location')->group(function () {
        Route::get('provinces', [LocationController::class, 'getProvinces']);
        Route::get('getLocation', [LocationController::class, 'getLocation']);
        Route::post('by-address', [LocationController::class, 'getLocationByAddress']);
    });

    // Routes with JWT Middleware
    Route::group(['middleware' => 'jwt.verify'], function () {

        // AUTH
        Route::get('auth/me', [AuthController::class, 'me']);

        // DASHBOARD ROUTE
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::put('changeStatus', [DashboardController::class, 'changeStatus'])->name('changeStatus');
            Route::put('changeStatusMultiple', [DashboardController::class, 'changeStatusMultiple'])->name('changeStatusMultiple');
            Route::delete('deleteMultiple', [DashboardController::class, 'deleteMultiple'])->name('deleteMultiple');
            Route::put('archiveMultiple', [DashboardController::class, 'archiveMultiple'])->name('archiveMultiple');
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

        // WIDGET ROUTE
        Route::apiResource('widgets', WidgetController::class);

        // VOUCHER ROUTE
        Route::apiResource('vouchers', VoucherController::class);


        // SLIDER ROUTE
        Route::apiResource('sliders', SliderController::class);

        // WISHLIST ROUTE
        Route::get('wishlists', [WishListController::class, 'index']);
        Route::get('wishlists/user', [WishListController::class, 'getByUser']);
        Route::post('wishlists', [WishListController::class, 'store']);
        Route::post('wishlists/carts', [WishListController::class, 'createOrUpdateCart']);
        Route::delete('wishlists/clean', [WishListController::class, 'destroyAll']);
        Route::delete('wishlists/{id}', [WishListController::class, 'destroy']);
        Route::get('wishlists/send-mail', [WishListController::class, 'sendWishListMail']);

        // USER ADDRESSES ROUTE
        Route::get('addresses', [UserAddressController::class, 'index']);
        Route::get('addresses/user', [UserAddressController::class, 'getByUserId']);
        Route::post('addresses', [UserAddressController::class, 'store']);
        Route::put('addresses/{id}', [UserAddressController::class, 'update']);
        Route::delete('addresses/{id}', [UserAddressController::class, 'destroy']);
        // ORDER ROUTE
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{code}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{id}', [OrderController::class, 'update'])->name('orders.update');


        // PRODUCT REVIEW ROUTE
        Route::controller(ProductReviewController::class)->name('product-reviews.')->group(function () {
            Route::get('product-reviews/{productId}', 'getReviewByProductId')->name('show');
            Route::post('product-reviews', 'store')->name('store');
            Route::post('product-reviews/{parentId}/replies', 'adminReply')->name('reply');
            Route::put('product-reviews/replies/{replyId}', 'adminUpdateReply')->name('updateReply');
        });
    });

    // CART ROUTE
    Route::controller(CartController::class)->name('cart.')->group(function () {
        Route::get('carts', 'index')->name('index');
        Route::post('carts', 'createOrUpdate')->name('store-or-update');
        Route::delete('carts/clean', 'forceDestroy')->name('force-destroy');
        Route::delete('carts/{id}', 'destroy')->name('destroy');
        Route::put('carts/handle-selected', 'handleSelected')->name('handle-selected');
        Route::delete('carts/delete-cart-selected', 'deleteCartSelected')->name('deleteCartSelected');
        Route::get('carts/add-paid-products', 'addPaidProductsToCart')->name('addPaidProducts');
    });
});
