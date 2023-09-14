<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'category',  'middleware' => 'checkAdmin'], function() {
        Route::get('getAll', [CategoryController::class,'index']);
        Route::post('add', [CategoryController::class,'addCategory']);
        Route::get('show/{id}', [CategoryController::class,'show']);
        Route::post('update/{id}', [CategoryController::class,'update']);
        Route::post('delete/{id}', [CategoryController::class,'destroy']);
    });
    Route::group(['prefix' => 'product',  'middleware' => 'checkAdmin'], function() {
        Route::get('getAll', [ProductController::class,'index']);
        Route::post('add', [ProductController::class,'addProduct']);
        Route::get('show/{id}', [ProductController::class,'show']);
        Route::post('update/{id}', [ProductController::class,'update']);
        Route::post('delete/{id}', [ProductController::class,'destroy']);
    });
    Route::group(['prefix' => 'brand',  'middleware' => 'checkAdmin'], function() {
        Route::get('getAll', [BrandController::class,'index']);
        Route::post('add', [BrandController::class,'addProduct']);
        Route::get('show/{id}', [BrandController::class,'show']);
        Route::post('update/{id}', [BrandController::class,'update']);
        Route::post('delete/{id}', [BrandController::class,'destroy']);
    });

});

