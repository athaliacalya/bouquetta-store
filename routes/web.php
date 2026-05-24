<?php

use App\Http\Controllers\BouquetController;
use App\Http\Controllers\CustomBouquetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FlowerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');

/*
|--------------------------------------------------------------------------
| Bouquet Builder API
|--------------------------------------------------------------------------
*/

Route::prefix('api')->group(function () {
    Route::get('/flowers', [BouquetController::class, 'flowers'])
        ->name('api.flowers');

    Route::post('/bouquets', [BouquetController::class, 'store'])
        ->name('api.bouquets.store');

    Route::get('/bouquets/{code}', [BouquetController::class, 'show'])
        ->name('api.bouquets.show');
});

/*
|--------------------------------------------------------------------------
| Custom Bouquet Builder
|--------------------------------------------------------------------------
| HARUS DI ATAS route /bouquet/{code}
*/

Route::prefix('bouquet/custom')
    ->name('custom-bouquet.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/', [CustomBouquetController::class, 'index'])
            ->name('index');

        Route::post('/store', [CustomBouquetController::class, 'store'])
            ->name('store');

        Route::post('/calculate', [CustomBouquetController::class, 'calculate'])
            ->name('calculate');
    });

/*
|--------------------------------------------------------------------------
| Shared Bouquet
|--------------------------------------------------------------------------
*/

Route::get('/bouquet/{code}', [BouquetController::class, 'view'])
    ->where('code', '^(?!custom$).+')
    ->name('bouquet.view');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/

Route::prefix('cart')
    ->name('cart.')
    ->group(function () {

        Route::get('/', [CartController::class, 'index'])
            ->name('index');

        Route::post('/add', [CartController::class, 'add'])
            ->name('add');

        Route::delete('/{cartItem}', [CartController::class, 'remove'])
            ->name('remove');

        Route::get('/count', [CartController::class, 'count'])
            ->name('count');
    });

/*
|--------------------------------------------------------------------------
| Checkout
|--------------------------------------------------------------------------
*/

Route::prefix('checkout')
    ->name('checkout.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/', [CheckoutController::class, 'index'])
            ->name('index');

        Route::post('/', [CheckoutController::class, 'store'])
            ->name('store');

        Route::get('/success/{orderNumber}', [CheckoutController::class, 'success'])
            ->name('success');
    });

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Flowers
        Route::resource('flowers', FlowerController::class);

        // Orders
        Route::resource('orders', OrderController::class)
            ->except(['create', 'store', 'edit']);

        Route::put('/orders/{order}/status', [OrderController::class, 'update'])
            ->name('orders.update-status');

        // Users
        Route::resource('users', UserController::class);
    });