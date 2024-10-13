<?php

use App\Http\Controllers\Payment\MomoController;
use App\Http\Controllers\Payment\PaypalController;
use App\Http\Controllers\Payment\VnpController;
<<<<<<< HEAD
=======
use App\Http\Controllers\Stringee\StringeeController;
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use League\Glide\Server;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//**** */ KHONG DUOC XOA HAY COMMENT ROUTE NAY ****//
Route::get('images/{path}', function (Server $server, Request $request, $path) {
    $server->outputImage($path, $request->all());
})->where('path', '.*')->name('glide');
//**** */ KHONG DUOC XOA HAY COMMENT ROUTE NAY ****//

// VNPAY
Route::get('return/vnpay', [VnpController::class, 'handleReturnUrl'])->name('return.vnpay');
Route::get('return/vnpay_ipn', [VnpController::class, 'handleVnpIpn'])->name('return.vnpay_ipn');

// MOMO
Route::get('return/momo', [MomoController::class, 'handleReturnUrl'])->name('return.momo');
Route::get('return/momo_ipn', [MomoController::class, 'handleMomoIpn'])->name('return.momo_ipn');

// PAYPAL
Route::get('paypal/success', [PaypalController::class, 'success'])->name('paypal.success');
Route::get('paypal/cancel', [PaypalController::class, 'cancel'])->name('paypal.cancel');

// STRINGEE
Route::get('stringee/answer', [StringeeController::class, 'answer']);

Route::get('test/', [UserAddressController::class, 'getByUserId']);
