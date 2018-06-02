<?php
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
//Rutas de usuario
Route::resource('/usuario', 'UsuarioController');

//Rutas de producto
Route::resource('/producto','ProductoController');
Route::get('/entradas/compra','EntradasController@compra')->name('compra');

//Rutas de sucursal
Route::get('/sucursal/alta', 'SucursalController@alta')->name('alta');
Route::post('/sucursal/guardar', 'SucursalController@store')->name('guardar');
Route::get('/sucursal/lista', 'SucursalController@lista')->name('lista');
Route::post('/sucursal/eliminar', 'SucursalController@destroy')->name('eliminar');



//Rutas de caja
Route::get('/caja/fondo', 'FondoController@index')->name('fondo');
Route::post('/caja/guardar-fondo', 'FondoController@saveFondo')->name('guardar-fondo');
