<?php
use App\Http\Controllers\ConfiguratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StartowaController;
use App\Http\Controllers\WyszukajWitrynaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;

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
    Route::get('/produkt', fn() => view('produkt'))->name('product.show');
    Route::get('/produkt/{product}', function (Product $product) {
        return view('produkt', compact('product'));
    })->name('products.show');
    Route::get('/produkt/{id}', function (int $id) {
        request()->merge(['id' => $id]);

        return view('produkt');
    })->whereNumber('id')->name('product.show.by-id');

        //Wyszukiwarka
    Route::get('/wyszukaj', [WyszukajWitrynaController::class, 'PrzeniesNaStrone']) ->name('wyszukaj');


        // Koszyk
    Route::get('/koszyk', fn() => view('koszyk'));


