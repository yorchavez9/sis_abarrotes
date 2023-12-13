<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\categoriaController;
use App\Http\Controllers\presentacionController;
use App\Http\Controllers\marcaController;
use App\Http\Controllers\ProductoController;



Route::get('/', function () {
    return view('template');
});

Route::view('/panel','panel.index')->name('panel');


Route::resources([
    'categorias' => categoriaController::class,
    'presentaciones' => presentacionController::class,
    'marcas' => marcaController::class,
    'productos' => ProductoController::class
]);


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