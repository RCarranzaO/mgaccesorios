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
        return view('almacen.almacen', compact('productos'));
    }
    public function pdf()
    {
        $productos = Producto::all();

        $pdf = PDF::loadView('almacen.almacen', ['productos' => $productos]);

        return $pdf->download('inventario.pdf');
    }
}
