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
Route::resource('/sucursal', 'SucursalController');



//Rutas de caja
Route::get('/caja/fondo', 'FondoController@index')->name('fondo');
Route::post('/caja/guardar-fondo', 'FondoController@saveFondo')->name('guardar-fondo');

//Ruta de egreso
Route::get('/caja/gasto', 'GastoController@index')->name('gasto');
Route::post('/caja/guardar-gasto', 'GastoController@saveGasto')->name('guardar-gasto');



//Rutas de almacen
Route::get('/inventario', 'AlmacenController@index')->name('inventario');



//Rutas de reportes
Route::get('/reporte/almacen', 'ReportesController@index')->name('repalmacen');
Route::get('/reporte/descargar-almacen', 'ReportesController@pdf')->name('almacen.pdf');



//Saldo
Route::get('/saldo/guardar', 'SaldoController@guardar')->name('guardar-saldo');
Route::get('/saldo', 'SaldoController@index')->name('saldo');



//PasswordReset
Route::post('/email/reset', 'EmailController@envio')->name('password');
