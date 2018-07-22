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
    
    /**
     * La función function_construct se encarga de verificar que el usuario ha iniciado sesión antes de poder realizar cualquier acción.
     * @return type
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $saldos = Saldo::all();
        $saldo = $saldos->last();
        $date = Carbon::now();
        $date = $date->toDateString();
        return view('saldo.saldo', compact('saldo', 'date'));
    }
    public function guardarFondo()
    {
        $saldo = new Saldo();
        $saldos = Saldo::all();
        $saldoId = $saldos->last();
        $fondo = Fondo::all();
        $fondoId = $fondo->last();
        $cobro = Cobro::all();
        $cobroId = $cobro->last();
        $devolucion = Devolucion::all();
        $devolucionId = $devolucion->last();
        $date = Carbon::now();

        if (empty($saldoId)) {
            $saldo->id_fondo = $fondoId->id_fondo;
            $saldo->saldo_actual = $fondoId->cantidad;
            $saldo->fecha = $date;
            $saldo->save();
        } elseif ($fondoId->id_fondo != $saldoId->id_fondo) {
            $saldo->id_fondo = $fondoId->id_fondo;
            $saldo->saldo_actual = $fondoId->cantidad;
            $saldo->fecha = $date;
            $saldo->save();
        } elseif ($fondoId->id_fondo == $saldoId->id_fondo) {
            $saldoId->id_fondo = $fondoId->id_fondo;
            $saldoId->saldo_actual = $fondoId->cantidad;
            $saldoId->fecha = $date;
            $saldoId->save();
        }
        //dd($saldo);

        return redirect()->route('home')->with('success', 'Movimiento realizado correctamente!');
        //return view('home', compact('saldo'));
    }
    public function guardarGasto()
    {
        $saldo = new Saldo();
        $saldos = Saldo::all();
        $saldoId = $saldos->last();
        $gasto = Gasto::all();
        $gastoId = $gasto->last();
        $fondo = Fondo::all();
        $fondoId = $fondo->last();
        $date = Carbon::now();


        //dd($saldoId);
        if (!empty($gastoId)){
            if ($gastoId->id_fondo == $saldoId->id_fondo) {
                //dd($gastoId);
                $saldo->id_fondo = $gastoId->id_fondo;
                $saldo->id_gasto = $gastoId->id_gasto;
                $saldo->saldo_actual = $saldoId->saldo_actual - $gastoId->cantidad;
                $saldo->fecha = $date;
            }
        }
        //dd($saldo);
        $saldo->save();
        return redirect()->route('home')->with('success', 'Movimiento realizado correctamente!');
    }
    public function guardarCobro()
    {
        /*if ($saldoId->id_cobro == null) {
          $saldo->id_cobro = $cobroId->id_cobro;
          $saldo->saldo_actual = $saldoId->saldo_actual + $cobroId->monto_total;
        } elseif ($cobroId->id_cobro != $saldoId->id_cobro) {
            $saldo->id_cobro = $cobroId->id_cobro;
            $saldo->saldo_actual = $saldoId->saldo_actual + $cobroId->monto_total;
        } else {
            $saldo->id_cobro = $cobroId->id_cobro;
        }*/
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
