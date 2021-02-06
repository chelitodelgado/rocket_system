<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// <-- Mi cuenta personal -->
Route::get('/mi-cuenta', 'SidebarController@profile');

// <-- Rutas empresa -->
Route::resource('/empresa', 'sidebar\PerfilController');
Route::post('/empresa/create', 'sidebar\PerfilController@create')->name('empresa.create');
Route::post('/empresa/update', 'sidebar\PerfilController@update')->name('empresa.update');
Route::get('/empresa/destroy/{id}', 'sidebar\PerfilController@destroy');

// <-- Rutas Categorias -->
Route::resource('/categoria', 'sidebar\CategoriaController');
Route::post('/categoria/update', 'sidebar\CategoriaController@update')->name('categoria.update');
Route::get('/categoria/destroy/{id}', 'sidebar\CategoriaController@destroy');

// <-- Rutas Proveedores -->
Route::resource('/proveedor', 'sidebar\ProveedorController');
Route::post('/proveedor/update', 'sidebar\ProveedorController@update')->name('proveedor.update');
Route::get('/proveedor/destroy/{id}', 'sidebar\ProveedorController@destroy');

// <-- Rutas Productos -->
Route::resource('/producto', 'sidebar\ProductoController');
Route::post('/producto/update', 'sidebar\ProductoController@update')->name('producto.update');
Route::get('/producto/destroy/{id}', 'sidebar\ProductoController@destroy');

// <-- Rutas Ventas -->
Route::resource('/ventas', 'sidebar\VentasController');
Route::post('/ventas/update', 'sidebar\VentasController@update')->name('ventas.update');
Route::get('/ventas/destroy/{id}', 'sidebar\VentasController@destroy');


