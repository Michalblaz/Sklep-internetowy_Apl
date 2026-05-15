<?php
use App\Http\Controllers\ConfiguratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StartowaController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\WyszukajWitrynaController;
use App\Http\Controllers\KoszykController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Livewire\Admin\ProductForm;

        //Strona startowa
    Route::get('/', [StartowaController::class, 'startowa'])->name('home');


        // Konfigurator
    Route::prefix('konfigurator')->group(function () {
        Route::get('/', [ConfiguratorController::class, 'index'])->name('konfigurator.index');
        Route::post('/select', [ConfiguratorController::class, 'selectProduct'])->name('configurator.select');
        Route::post('/reset', [ConfiguratorController::class, 'resetBuild'])->name('configurator.reset');
        Route::get('/remove/{category}/{index}', [ConfiguratorController::class, 'removeFromBuild'])->name('konfigurator.remove');
    });

        // Logowanie / Rejestracja
    Route::get('/log_in', [AuthController::class, 'showLoginForm'])->name('log_in');
    Route::get('/sing_in', [AuthController::class, 'showSinginForm'])->name('sing_in');

        // Strona Produktu
    Route::get('/produkt', [ProductPageController::class, 'show'])->name('product.show');
    Route::get('/produkt/{id}', [ProductPageController::class, 'show'])->whereNumber('id')->name('products.show');
    Route::post('/produkt/{id}/opinie', [ProductPageController::class, 'storeReview'])->whereNumber('id')->middleware('auth')->name('products.reviews.store');

        //Wyszukiwarka
    Route::get('/wyszukiwanie/podpowiedzi', [WyszukajWitrynaController::class, 'suggestions'])
    ->name('wyszukaj.suggestions');

    Route::get('/wyszukiwanie', [WyszukajWitrynaController::class, 'PrzeniesNaStrone'])
    ->name('wyszukaj');

        // Koszyk
    Route::get('/koszyk', [KoszykController::class, 'index'])->name('koszyk');



     // Admin
     Route::get('/admin', [AdminController::class, 'index'])->name('admin');
     Route::get('/admin/products/create', ProductForm::class)->name('admin.products.create');
     Route::post('/admin/users/{user}/suspend', [AdminController::class, 'suspend'])->name('admin.users.suspend');
     Route::post('/admin/users/{user}/ban', [AdminController::class, 'ban'])->name('admin.users.ban');
     Route::post('/admin/users/{user}/unban', [AdminController::class, 'unban'])->name('admin.users.unban');

     // Logowanie / Rejestracja
    Route::get('/log_in', [AuthController::class, 'showLoginForm'])->name('log_in');
    Route::post('/log_in', [AuthController::class, 'login']);

    Route::get('/sing_in', [AuthController::class, 'showSinginForm'])->name('sing_in');
    Route::post('/sing_in', [AuthController::class, 'register']);

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

    // Profil
    Route::middleware(['auth'])->group(function () {
        Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
    });
