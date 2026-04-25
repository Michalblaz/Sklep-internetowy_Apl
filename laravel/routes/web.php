<?php
use App\Http\Controllers\ConfiguratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StartowaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', fn() => view('app'));
Route::get('/koszyk', fn() => view('koszyk'));
Route::get('/konfigurator', fn() => view('konfigurator'));
Route::get('/products', [ConfiguratorController::class, 'index'])->name('products.index');
Route::get('/log_in', [AuthController::class, 'showLoginForm'])->name('log_in');
Route::get('/sing_in', [AuthController::class, 'showSinginForm'])->name('sing_in');

Route::post('/configurator/select', function (Request $request) {
    $selection = session()->get('configurator_build', []);

    $selection[$request->category_id] = [
        'id' => $request->product_id,
        'name' => $request->name,
        'price' => $request->price,
    ];

    session()->put('configurator_build', $selection);

    return redirect()->back();
})->name('configurator.select');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/startowa', [StartowaController::class, 'startowa'])->name('startowa');
Route::get('/', [StartowaController::class, 'startowa']);
