<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use mgaccesorios\Fondo;
use mgaccesorios\Cobro;
use mgaccesorios\Gasto;
use mgaccesorios\Devolucion;

class SaldoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $saldo = new Saldo();
        $fondo = Fondo::all();
        $fondoId = $fondo->last();
        $cobro = Cobro::all();
        $cobroId = $cobro->last();
        $gasto = Gasto::all();
        $gastoId = $gasto->last();
        $devolucion = Devolucion::all();
        $devolucionId = $devolucion->last();

        



        return view('home', compact('saldo'));
    }
}
