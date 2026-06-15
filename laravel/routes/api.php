<?php

use App\Http\Controllers\Api\BrandApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('/status', fn () => response()->json([
        'status' => 'ok',
        'message' => 'REST API działa',
    ]))->name('status');

    Route::apiResource('products', ProductApiController::class)->only(['index', 'show']);
    Route::apiResource('categories', CategoryApiController::class)->only(['index', 'show']);
    Route::get('/brands', [BrandApiController::class, 'index'])->name('brands.index');
});
