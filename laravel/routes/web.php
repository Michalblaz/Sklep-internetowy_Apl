<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StartowaController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('app'));
Route::get('/koszyk', fn() => view('koszyk'));
Route::get('/konfigurator', fn() => view('konfigurator'));
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/startowa', [StartowaController::class, 'startowa'])->name('startowa');
Route::get('/', [StartowaController::class, 'startowa']);
