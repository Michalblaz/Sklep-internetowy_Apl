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
    Route::get('/', [StartowaController::class, 'startowa'])->middleware('throttle:120,1')->name('home');
    Route::post('/statystyki/wyswietlenie', [StartowaController::class, 'recordPageView'])
        ->middleware('throttle:20,1')
        ->name('home.views.record');


        // Konfigurator
    Route::prefix('konfigurator')->group(function () {
        Route::get('/', [ConfiguratorController::class, 'index'])->name('konfigurator.index');
        Route::post('/select', [ConfiguratorController::class, 'selectProduct'])->name('configurator.select');
        Route::post('/reset', [ConfiguratorController::class, 'resetBuild'])->name('configurator.reset');
        Route::post('/do-koszyka', [App\Http\Controllers\ConfiguratorController::class, 'moveToCart'])->name('konfigurator.moveToCart');
        Route::get('/remove/{category}/{index}', [ConfiguratorController::class, 'removeFromBuild'])->name('konfigurator.remove');
    });

        // Strona Produktu
    Route::get('/produkt', [ProductPageController::class, 'show'])->name('product.show');
    Route::get('/produkt/{id}', [ProductPageController::class, 'show'])->whereNumber('id')->name('products.show');
    Route::post('/produkt/{id}/opinie', [ProductPageController::class, 'storeReview'])->whereNumber('id')->middleware('auth')->name('products.reviews.store');
    Route::get('/products/{id}/wishlists', [\App\Http\Controllers\ProductPageController::class, 'getWishlists'])->name('products.wishlists.get');
    Route::post('/products/{id}/wishlists', [\App\Http\Controllers\ProductPageController::class, 'saveToWishlist'])->name('products.wishlists.save');

        //Wyszukiwarka
    Route::get('/wyszukiwanie/podpowiedzi', [WyszukajWitrynaController::class, 'suggestions'])
    ->middleware('throttle:30,1')
    ->name('wyszukaj.suggestions');

    Route::get('/wyszukiwanie', [WyszukajWitrynaController::class, 'PrzeniesNaStrone'])
    ->middleware('throttle:60,1')
    ->name('wyszukaj');



        // Koszyk
    Route::get('/koszyk', [KoszykController::class, 'index'])->name('cart.index');
    Route::post('/koszyk/dodaj', [KoszykController::class, 'add'])->name('cart.add');
    Route::post('/koszyk/usun', [KoszykController::class, 'remove'])->name('cart.remove');
    Route::post('/koszyk/aktualizuj', [KoszykController::class, 'update'])->name('cart.update');
    Route::post('/koszyk/wyczysc', [KoszykController::class, 'clear'])->name('cart.clear');
    Route::post('/koszyk/ubezpieczenie', [KoszykController::class, 'toggleInsurance'])->name('cart.insurance');
    Route::get('/koszyk/transakcje', [KoszykController::class, 'Transakcje'])->name('transakcje');
    Route::post('/koszyk/transakcje/zapisz', [KoszykController::class, 'storeTransaction'])->name('transakcje.store');




     // Admin
     Route::middleware(['auth', 'admin', 'throttle:120,1'])->group(function () {
         Route::get('/admin', [AdminController::class, 'index'])->name('admin');
         Route::get('/admin/products/create', ProductForm::class)->name('admin.products.create');
         Route::post('/admin/users/{user}/suspend', [AdminController::class, 'suspend'])->middleware('throttle:30,1')->whereNumber('user')->name('admin.users.suspend');
         Route::post('/admin/users/{user}/ban', [AdminController::class, 'ban'])->middleware('throttle:30,1')->whereNumber('user')->name('admin.users.ban');
         Route::post('/admin/users/{user}/unban', [AdminController::class, 'unban'])->middleware('throttle:30,1')->whereNumber('user')->name('admin.users.unban');
         Route::post('/admin/reklamacje/{complaint}/decyzja', [AdminController::class, 'updateComplaint'])->middleware('throttle:30,1')->whereNumber('complaint')->name('admin.complaints.update');
         Route::post('/admin/products/{product}/archive', [AdminController::class, 'archiveProduct'])->middleware('throttle:30,1')->whereNumber('product')->name('admin.products.archive');
         Route::post('/admin/products/{product}/restore', [AdminController::class, 'restoreProduct'])->middleware('throttle:30,1')->whereNumber('product')->name('admin.products.restore');
     });

     // Logowanie / Rejestracja
    Route::middleware('guest')->group(function () {
        Route::get('/log_in', [AuthController::class, 'showLoginForm'])->name('log_in');
        Route::post('/log_in', [AuthController::class, 'login'])->middleware('throttle:20,1');

        Route::get('/sing_in', [AuthController::class, 'showSinginForm'])->name('sing_in');
        Route::post('/sing_in', [AuthController::class, 'register'])->middleware('throttle:10,1');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

    // Profil
    Route::middleware(['auth'])->group(function () {
        Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
        Route::post('/profil', [ProfileController::class, 'update'])->name('profil.update');
        Route::post('/profil/reklamacje', [ProfileController::class, 'storeComplaint'])->name('profil.complaints.store');
        Route::post('/profil/reklamacje/{complaintId}/odpowiedz', [ProfileController::class, 'replyComplaint'])
            ->whereNumber('complaintId')
            ->name('profil.complaints.reply');
        Route::post('/profil/lista/{productId}/do-koszyka', [ProfileController::class, 'moveObservedToCart'])
            ->whereNumber('productId')
            ->name('profil.saved.move-to-cart');
        Route::post('/profil/lista/{wishlistId}/{productId}/usun', [ProfileController::class, 'removeObserved'])
            ->where(['wishlistId' => '[0-9]+', 'productId' => '[0-9]+'])
            ->name('profil.saved.remove');
        Route::post('/profil/lista/{wishlistId}/{productId}/do-koszyka', [ProfileController::class, 'moveObservedToCart'])
            ->whereNumber(['wishlistId', 'productId'])
            ->name('profil.saved.move-to-cart');
        });
