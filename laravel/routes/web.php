<?php

use App\Http\Controllers\TestController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [TestController::class, 'index']);
Route::get('/emails', function () {
    return view('emails.forgot-email');
});

Route::get('/notification/{boolean}/{messages}', function ($boolean, $messages) {
    return view('auth.notification', compact(
        'boolean',
        'messages'
    ));
})->name('notifications');

Route::get('images/{path}', function (Server $server, Request $request, $path) {
    $server->outputImage($path, $request->all());
})->where('path', '.*')->name('glide');
