<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use mgaccesorios\Saldo;
use mgaccesorios\Fondo;
use mgaccesorios\Cobro;
use mgaccesorios\Gasto;
use mgaccesorios\Devolucion;
use Carbon\Carbon;
use mgaccesorios\Venta;
use mgaccesorios\Sucursal;
use mgaccesorios\Producto;

class SaldoController extends Controller
{

    /**
     * La función function_construct se encarga de verificar que el usuario ha iniciado sesión antes de poder realizar cualquier acción.
     * @return
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * La función index apunta al archivo saldo.blade.php.
     * @return Devuelve la vista del saldo actual en caja.
     */
    public function index()
    {
        $user = \Auth::user();
        $saldos = Saldo::all()->where('id_sucursal', $user->id_sucursal);
        $saldo = $saldos->last();
        $date = Carbon::now();
        $date = $date->toDateString();
        return view('saldo.saldo', compact('saldo', 'date'));
    }

    /**
     * La función guardarFondo crea el saldo de caja tomando la cantidad registrada en el fondo. Si este es modificado sobreescribe la información del fondo y saldo toma el valor del fondo.
     * Si se ha realizado una venta, la cantidad de la venta se suma al saldo que tomó el valor de fondo y aumenta conforme a la cantidad de cobro.
     * @return Si el fondo no se ha alterado antes de modificarlo por medio de la realización de una venta o devolución muestra un mensaje confirmando que el cambio ha sido realizado con éxito.
     */
    public function guardarFondo()
    {
        $user = \Auth::user();
        $saldo = new Saldo();
        $saldos = Saldo::all()->where('id_sucursal', $user->id_sucursal);
        $saldoId = $saldos->last();
        $fondo = Fondo::all()->where('id_sucursal', $user->id_sucursal);
        $fondoId = $fondo->last();
        $date = Carbon::now()->toDateString();

        if (empty($saldoId)) {
            $saldo->id_fondo = $fondoId->id_fondo;
            $saldo->saldo_actual = $fondoId->cantidad;
            $saldo->id_sucursal = $user->id_sucursal;
            $saldo->fecha = $date;
            $saldo->save();
        } elseif ($fondoId->id_fondo != $saldoId->id_fondo) {
            $saldo->id_fondo = $fondoId->id_fondo;
            $saldo->saldo_actual = $fondoId->cantidad;
            $saldo->id_sucursal = $user->id_sucursal;
            $saldo->fecha = $date;
            $saldo->save();
        } elseif ($fondoId->id_fondo == NULL) {
            $saldoId->id_fondo = $fondoId->id_fondo;
            $saldoId->saldo_actual = $fondoId->cantidad;
            $saldoId->id_sucursal = $user->id_sucursal;
            $saldoId->fecha = $date;
            $saldoId->save();
        }

        return redirect()->route('home')->with('success', 'Movimiento realizado correctamente!');

    }

    /**
     * La función guardarGasto crea un nuevo saldo pero aún no guarda información en el. Si no se ha realizado un retiro de dinero (gasto) toma el valor de fondo y lo asigna al nuevo saldo, entonces gasto toma el valor del saldo también.
     * Si se ha realizado algún retiro de dinero, entonces saldo toma el valor del gasto y lo resta del saldo actual y lo guarda como el nuevo saldo.
     * @return Si el retiro de dinero se realiza exitosamente se muestra un mensaje de confirmación y nos redirige a la pantalla principal del software Mg Accesorios.
     */
    public function guardarGasto()
    {
        $user = \Auth::user();
        $saldo = new Saldo();
        $saldos = Saldo::all()->where('id_sucursal', $user->id_sucursal);
        $saldoId = $saldos->last();
        $gasto = Gasto::all()->where('id_sucursal', $user->id_sucursal);
        $gastoId = $gasto->last();
        $date = Carbon::now()->toDateString();

        if ($saldoId->id_gasto == null){
            $saldo->id_gasto = $gastoId->id_gasto;
            $saldo->saldo_actual = $saldoId->saldo_actual - $gastoId->cantidad;
            $saldo->id_sucursal = $user->id_sucursal;
            $saldo->fecha = $date;
        } elseif ($gastoId->id_gasto != $saldoId->id_gasto) {
            $saldo->id_gasto = $gastoId->id_gasto;
            $saldo->saldo_actual = $saldoId->saldo_actual - $gastoId->cantidad;
            $saldo->id_sucursal = $user->id_sucursal;
            $saldo->fecha = $date;
        }

        $saldo->save();
        return redirect()->route('home')->with('success', 'Movimiento realizado correctamente!');
    }

    /**
     * Description
     * @return type
     */
    public function guardarCobro()
    {
        $saldo = new Saldo();
        $saldos = Saldo::all()->where('id_sucursal', $user->id_sucursal);
        $saldoId = $saldos->last();
        $cobro = Cobro::all()->where('id_sucursal', $user->id_sucursal)->last();
        $date = Carbon::now()->toDateString();

        if ($saldoId->id_cobro == null) {
            $saldo->id_cobro = $cobro->id_cobro;
            $saldo->saldo_actual = $saldoId->saldo_actual + $cobro->monto_total;
            $saldo->id_sucursal = $user->id_sucursal;
            $saldo->fecha = $date;
        } elseif ($cobro->id_cobro != $saldoId->id_cobro) {
            $saldo->id_cobro = $cobro->id_cobro;
            $saldo->saldo_actual = $saldoId->saldo_actual + $cobro->monto_total;
            $saldo->id_sucursal = $user->id_sucursal;
            $saldo->fecha = $date;
        }
        $saldo->save();
        return redirect()->route('venta.index')->with('success', 'Venta realizada correctamente');

    }
    public function guardarDev()
    {
        /*if ($saldoId->id_devolucion == null) {
          $saldo->id_devolucion = $devolucionId->id_devolucion;
          $saldo->saldo_actual = $saldoId->saldo_actual - $devolucionId->cantidad;
        } elseif ($devolucionId->id_devolucion != $saldoId->id_devolucion) {
            $saldo->id_devolucion = $devolucionId->id_devolucion;
            $saldo->saldo_actual = $saldoId->saldo_actual - $devolucionId->cantidad;
        } else {
            $saldo->id_devolucion = $devolucionId->id_devolucion;
        }*/
    }
}
