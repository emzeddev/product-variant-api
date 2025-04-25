<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::group(['prefix' => 'v1'], function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    Route::group(['prefix' => 'attributes'] , function() {
        Route::get('/', [ProductController::class, 'getAttributes']);
        Route::post('/', [ProductController::class, 'saveAttribute']);
    });

    Route::group(['prefix' => 'categories'] , function() {
        Route::get('/', [ProductController::class, 'getCategories']);
        Route::post('/', [ProductController::class, 'saveCategory']);
    });

    Route::group(['prefix' => 'brands'] , function() {
        Route::get('/', [ProductController::class, 'getBrands']);
        Route::post('/', [ProductController::class, 'saveBrand']);
    });

    Route::group(['prefix' => 'tags'] , function() {
        Route::get('/', [ProductController::class, 'getTags']);
        Route::post('/', [ProductController::class, 'saveTag']);
    });

    Route::group(['prefix' => 'tiny'] , function() {
        Route::post('/', [ProductController::class, 'uploadTinyFile']);
    });
});


