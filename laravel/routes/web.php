<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('app'));
Route::get('/koszyk', fn() => view('koszyk'));
Route::get('/profil', fn() => view('profil'));
Route::get('/konfigurator', fn() => view('konfigurator'));
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/log_in', [AuthController::class, 'showLoginForm'])->name('log_in');
Route::get('/sing_in', [AuthController::class, 'showSinginForm'])->name('sing_in');