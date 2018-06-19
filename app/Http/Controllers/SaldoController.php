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

class SaldoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $saldos = Saldo::all();
        $saldo = $saldos->last();
        return view('saldo.saldo', compact('saldo'));
    }
    public function guardar()
    {
        $saldo = new Saldo();
        $saldos = Saldo::all();
        $saldoId = $saldos->last();
        $fondo = Fondo::all();
        $fondoId = $fondo->last();
        $cobro = Cobro::all();
        $cobroId = $cobro->last();
        $gasto = Gasto::all();
        $gastoId = $gasto->last();
        $devolucion = Devolucion::all();
        $devolucionId = $devolucion->last();
        $date = Carbon::now();

        if (!$saldoId) {
            $saldo->id_fondo = $fondoId->id_fondo;
            $saldo->saldo_actual = $fondoId->cantidad;
            $saldo->fecha = $date;
        } elseif ($fondoId->id_fondo != $saldoId->id_fondo) {
            $saldo->id_fondo = $fondoId->id_fondo;
            $saldo->saldo_actual = $fondoId->cantidad;
            $saldo->fecha = $date;
        } elseif ($fondoId->id_fondo == $saldoId->id_fondo) {
            $saldo->id_fondo = $fondoId->id_fondo;
            $saldo->saldo_actual = $fondoId->cantidad;
            $saldo->fecha = $date;
        }

        /*if ($saldoId->id_cobro == null) {
          $saldo->id_cobro = $cobroId->id_cobro;
          $saldo->saldo_actual = $saldoId->saldo_actual + $cobroId->monto_total;
        } elseif ($cobroId->id_cobro != $saldoId->id_cobro) {
            $saldo->id_cobro = $cobroId->id_cobro;
            $saldo->saldo_actual = $saldoId->saldo_actual + $cobroId->monto_total;
        } else {
            $saldo->id_cobro = $cobroId->id_cobro;
        }*/

        if ($gastoId->fecha == $date) {
            $saldo->id_gasto = $gastoId->id_gasto;
            $saldo->saldo_actual = $saldoId->saldo_actual - $gastoId->cantidad;
            $saldo->fecha = $date;
        } elseif ($gastoId->id_gasto != $saldoId->id_gasto) {
            $saldo->id_gasto = $gastoId->id_gasto;
            $saldo->saldo_actual = $saldoId->saldo_actual - $gastoId->cantidad;
            $saldo->fecha = $date;
        }

        /*if ($saldoId->id_devolucion == null) {
          $saldo->id_devolucion = $devolucionId->id_devolucion;
          $saldo->saldo_actual = $saldoId->saldo_actual - $devolucionId->cantidad;
        } elseif ($devolucionId->id_devolucion != $saldoId->id_devolucion) {
            $saldo->id_devolucion = $devolucionId->id_devolucion;
            $saldo->saldo_actual = $saldoId->saldo_actual - $devolucionId->cantidad;
        } else {
            $saldo->id_devolucion = $devolucionId->id_devolucion;
        }*/

        $saldo->save();

        return redirect()->route('home')->with('success','Data Added');
        //return view('home', compact('saldo'));
    }
}
