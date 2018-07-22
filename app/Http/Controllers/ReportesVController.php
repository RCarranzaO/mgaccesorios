<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Producto;

class ReportesVController extends Controller
{
    
    /**
     * La función function_construct se encarga de verificar que el usuario ha iniciado sesión antes de poder realizar cualquier acción.
     * @return
     */
    public function __construct()
    {
       $this->middleware('auth');
    }
    public function index()
    {
      $productos = DB::table('detallealmacen')
          ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
          ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
          ->select('producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia')
          ->get();
        return view('reportes.ventas', compact('productos'));
    }
    public function pdf()
    {

        //$sucursales = Sucursal::all();
        $productos = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia')
            ->get();
        $fecha = date('Y-m-d');

        $pdf = PDF::loadView('reportes.ventaspdf', compact('productos', 'fecha'));

        return $pdf->download('inventario_'.$fecha.'.pdf');
    }
}
