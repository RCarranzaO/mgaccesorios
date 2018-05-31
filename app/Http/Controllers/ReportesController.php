<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use mgaccesorios\Producto;

class ReportesController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }
    public function index()
    {
        $productos = Producto::all();
        return view('reportes.inventario', compact('productos'));
    }
    public function pdf()
    {
        $productos = Producto::all();
        $fecha = date('Y-m-d');

        $pdf = PDF::loadView('reportes.inventariopdf', compact('productos'));

        return $pdf->download('inventario_'.$fecha.'.pdf');
    }
}
