<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\CheckLoginMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {

    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('processLogin', [AuthController::class, 'processLogin'])->name('processLogin');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('processRegister', [AuthController::class, 'processRegister'])->name('processRegister');

    Route::group(['middleware' => CheckLoginMiddleware::class, ['web']], function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');

        Route::group(['prefix' => 'customer'], function () {
            Route::get('/', [CustomerController::class, 'index'])->name('admin.customer.index');
            Route::get('/create', [CustomerController::class, 'create'])->name('admin.customer.create');
            Route::post('/create', [CustomerController::class, 'store'])->name('admin.customer.store');
            Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('admin.customer.edit');
            Route::put('/edit/{id}', [CustomerController::class, 'update'])->name('admin.customer.update');
            Route::delete('/delete/{id}', [CustomerController::class, 'destroy'])->name('admin.customer.destroy');
        });

        Route::group(['prefix' => 'order'], function () {
            Route::get('/', [OrderController::class, 'index'])->name('admin.order.index');
            Route::get('/create', [OrderController::class, 'create'])->name('admin.order.create');
            Route::post('/create', [OrderController::class, 'store'])->name('admin.order.store');
            Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('admin.order.edit');
            Route::put('/edit/{id}', [OrderController::class, 'update'])->name('admin.order.update');
        });

        Route::group(['prefix' => 'orderdetail'], function () {
            Route::get('/', [OrderController::class, 'orderDetail'])->name('admin.orderdetail.index');
        });

        Route::group(['prefix' => 'product'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
            Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
            Route::post('/create', [ProductController::class, 'store'])->name('admin.product.store');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
            Route::put('/edit/{id}', [ProductController::class, 'update'])->name('admin.product.update');
            Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
        });

        Route::group(['prefix' => 'category'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
            Route::post('/create', [CategoryController::class, 'store'])->name('admin.category.store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
            Route::put('/edit/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        });

        Route::group(['prefix' => 'brand'], function () {
            Route::get('/', [BrandController::class, 'index'])->name('admin.brand.index');
            Route::get('/create', [BrandController::class, 'create'])->name('admin.brand.create');
            Route::post('/create', [BrandController::class, 'store'])->name('admin.brand.store');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('admin.brand.edit');
            Route::put('/edit/{id}', [BrandController::class, 'update'])->name('admin.brand.update');
        });
    });
});
