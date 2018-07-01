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

//Auth::routes();
//Rutas  de logueo
Route::get('/login', 'AuthController@index')->name('login');
Route::post('/login/check', 'AuthController@checklogin')->name('check');
Route::post('/logout' ,'AuthController@logout')->name('logout');




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
Route::resource('/almacen', 'AlmacenController');
Route::post('/almacen-search', 'BuscarController@BuscarAlm')->name('buscaralm');


//Rutas de reportes
Route::get('/reporte/almacen', 'ReportesController@index')->name('repalmacen');
Route::get('/reporte/descargar-almacen', 'ReportesController@pdf')->name('almacen.pdf');
Route::get('/reporte/venta', 'ReportesVController@index')->name('repventa');
Route::get('/reporte/descargar-venta', 'ReportesVController@pdf')->name('venta.pdf');

//Rutas de Saldo
Route::get('/saldo/guardarF', 'SaldoController@guardarFondo')->name('guardarFondo');
Route::get('/saldo', 'SaldoController@index')->name('saldo');
Route::get('/saldo/guardarG', 'SaldoController@guardarGasto')->name('guardarGasto');


//Rutas de PasswordReset
Route::get('/mail', 'ForgotPasswordController@showForm')->name('show');
Route::post('/send', 'ForgotPasswordController@sendResetEmail')->name('send');
Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('reset');
Route::post('/password/reset', 'ResetPasswordController@reset')->name('reseted');


//Rutas de salida
Route::resource('/salidasesp', 'SalidasespController');
Route::resource('/traspaso', 'TraspasoController');
Route::resource('/venta', 'VentaController');
