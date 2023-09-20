<?php

use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'category',  'middleware' => 'checkAdmin'], function() {
        Route::get('getAll', [CategoryController::class,'index']);
        Route::post('add', [CategoryController::class,'addCategory']);
        Route::get('show/{id}', [CategoryController::class,'show']);
        Route::post('update/{id}', [CategoryController::class,'update']);
        Route::delete('delete/{id}', [CategoryController::class,'destroy']);
    });
    Route::group(['prefix' => 'product',  'middleware' => 'checkAdmin'], function() {
        Route::get('getAll', [ProductController::class,'index']);
        Route::post('add', [ProductController::class,'addProduct']);
        Route::get('show/{id}', [ProductController::class,'show']);
        Route::post('update/{id}', [ProductController::class,'update']);
        Route::delete('delete/{id}', [ProductController::class,'destroy']);
    });
    Route::group(['prefix' => 'brand',  'middleware' => 'checkAdmin'], function() {
        Route::get('getAll', [BrandController::class,'index']);
        Route::post('add', [BrandController::class,'addBrand']);
        Route::get('show/{id}', [BrandController::class,'show']);
        Route::post('update/{id}', [BrandController::class,'update']);
        Route::delete('delete/{id}', [BrandController::class,'destroy']);
    });
    Route::group(['prefix' => 'customer',  'middleware' => 'checkAdmin'], function() {
        Route::get('getAll', [CustomerController::class,'index']);
        Route::post('add', [CustomerController::class,'createCustomer']);
        Route::get('show/{id}', [CustomerController::class,'show']);
        Route::post('update/{id}', [CustomerController::class,'update']);
        Route::delete('delete/{id}', [CustomerController::class,'destroy']);
    });

    Route::group(['prefix' => 'attribute',  'middleware' => 'checkAdmin'], function() {
        Route::get('getAll', [AttributeController::class,'index']);
        Route::post('add', [AttributeController::class,'create']);
        Route::get('show/{id}', [AttributeController::class,'show']);
        Route::post('update/{id}', [AttributeController::class,'update']);
        Route::delete('delete/{id}', [AttributeController::class,'destroy']);
    });

    Route::group(['prefix' => 'order',  'middleware' => 'checkAdmin'], function() {
        Route::get('getAll', [OrderController::class,'index']);
        Route::post('add', [OrderController::class,'create']);
        Route::get('show/{id}', [OrderController::class,'show']);
        Route::post('update/{id}', [OrderController::class,'update']);
        Route::delete('delete/{id}', [OrderController::class,'destroy']);
    });


});

