Route::get('/', function () {
    return view('home');
});

Route::get('/koszyk', function () {
    return view('koszyk');
});

Route::get('/profil', function () {
    return view('profil');
});

Route::get('/konfigurator', function () {
    return view('konfigurator');
});