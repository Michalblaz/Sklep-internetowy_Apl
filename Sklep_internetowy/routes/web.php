<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('app'));
Route::get('/koszyk', fn() => view('koszyk'));
Route::get('/profil', fn() => view('profil'));
Route::get('/konfigurator', fn() => view('konfigurator'));
