<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\categoriaController;
use App\Http\Controllers\presentacionController;


Route::get('/', function () {
    return view('template');
});

Route::view('/panel','panel.index')->name('panel');

/* Route::view('/categorias','categoria.index')->name('categorias'); */

Route::resource('categorias', categoriaController::class);
Route::resource('presentaciones', presentacionController::class);

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/401', function () {
    return view('pages.401');
});

Route::get('/login', function () {
    return view('pages.404');
});

Route::get('/login', function () {
    return view('pages.500');
});