<?php
use App\Http\Controllers\ConfiguratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StartowaController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\WyszukajWitrynaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

        //Strona startowa
    Route::get('/', [StartowaController::class, 'startowa'])->name('home');


        // Konfigurator
    Route::prefix('konfigurator')->group(function () {
        Route::get('/', [ConfiguratorController::class, 'index'])->name('konfigurator.index');
        Route::post('/select', [ConfiguratorController::class, 'selectProduct'])->name('configurator.select');
        Route::post('/reset', [ConfiguratorController::class, 'resetBuild'])->name('configurator.reset');
    });

        // Logowanie / Rejestracja
    Route::get('/log_in', [AuthController::class, 'showLoginForm'])->name('log_in');
    Route::get('/sing_in', [AuthController::class, 'showSinginForm'])->name('sing_in');

        // Strona Produktu
    Route::get('/produkt', [ProductPageController::class, 'show'])->name('product.show');
    Route::get('/produkt/{id}', [ProductPageController::class, 'show'])->whereNumber('id')->name('products.show');

        //Wyszukiwarka
    Route::get('/wyszukaj', [WyszukajWitrynaController::class, 'PrzeniesNaStrone']) ->name('wyszukaj');


        // Koszyk
    Route::get('/koszyk', fn() => view('koszyk'));



     // Admin
     Route::get('/admin', [AdminController::class, 'index'])->name('admin');
     Route::post('/admin/users/{user}/suspend', [AdminController::class, 'suspend'])->name('admin.users.suspend');
     Route::post('/admin/users/{user}/ban', [AdminController::class, 'ban'])->name('admin.users.ban');

     // Logowanie / Rejestracja
    Route::get('/log_in', [AuthController::class, 'showLoginForm'])->name('log_in');
    Route::post('/log_in', [AuthController::class, 'login']);

    Route::get('/sing_in', [AuthController::class, 'showSinginForm'])->name('sing_in');
    Route::post('/sing_in', [AuthController::class, 'register']);

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
