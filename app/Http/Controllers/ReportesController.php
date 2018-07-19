<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use mgaccesorios\DetalleAlmacen;
use mgaccesorios\Producto;
use mgaccesorios\Sucursal;

class ReportesController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }
    public function index()
    {
        $sucursales = Sucursal::all();
        $productos = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia')
            ->orderBy('detallealmacen.id_detallea')
            ->paginate(15);
        return view('reportes.inventario', compact('productos', 'sucursales'));
    }

    public function buscarR(Request $request)
    {
        if ($request->ajax()) {

            $result = "";
            $productos = DB::table('detallealmacen')
                              ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                              ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                              ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
                              ->orderBy('detallealmacen.id_detallea')
                              ->get();
            if ($request->buscador == "0") {
                $productos = DB::table('detallealmacen')
                              ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                              ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                              ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
                              ->orderBy('detallealmacen.id_detallea')
                              ->where('producto.referencia', 'like', '%'.$request->buscar.'%')
                              ->orWhere('producto.categoria_producto', 'like', '%'.$request->buscar.'%')
                              ->orWhere('producto.tipo_producto', 'like', '%'.$request->buscar.'%')
                              ->orWhere('producto.marca', 'like', '%'.$request->buscar.'%')
                              ->orWhere('producto.modelo', 'like', '%'.$request->buscar.'%')
                              ->orWhere('producto.color', 'like', '%'.$request->buscar.'%')
                              ->get();
            }elseif ($request->buscador == "referencia") {
                $productos = DB::table('detallealmacen')
                              ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                              ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                              ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
                              ->orderBy('detallealmacen.id_detallea')
                              ->where('producto.referencia', 'like', '%'.$request->buscar.'%')
                              ->get();
            }elseif ($request->buscador == "categoria_producto") {
                $productos = DB::table('detallealmacen')
                              ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                              ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                              ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
                              ->orderBy('detallealmacen.id_detallea')
                              ->where('producto.categoria_producto', 'like', '%'.$request->buscar.'%')
                              ->get();
            }elseif ($request->buscador == "tipo_producto") {
                $productos = DB::table('detallealmacen')
                              ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                              ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                              ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
                              ->orderBy('detallealmacen.id_detallea')
                              ->where('producto.tipo_producto', 'like', '%'.$request->buscar.'%')
                              ->get();
            }elseif ($request->buscador == "marca") {
                $productos = DB::table('detallealmacen')
                              ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                              ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                              ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
                              ->orderBy('detallealmacen.id_detallea')
                              ->where('producto.marca', 'like', '%'.$request->buscar.'%')
                              ->get();
            }elseif ($request->buscador == "modelo") {
                $productos = DB::table('detallealmacen')
                              ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                              ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                              ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
                              ->orderBy('detallealmacen.id_detallea')
                              ->where('producto.modelo', 'like', '%'.$request->buscar.'%')
                              ->get();
            }elseif ($request->buscador == "color") {
                $productos = DB::table('detallealmacen')
                              ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                              ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                              ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
                              ->orderBy('detallealmacen.id_detallea')
                              ->where('producto.color', 'like', '%'.$request->buscar.'%')
                              ->get();
            }
            
            if ($productos) {
                foreach ($productos as $producto) {
                    if ($producto->estatus != 0) {
                        $result.= '<tr>'.
                            '<td>'.$producto->referencia.'</td>'.
                            '<td class="text-left">'.$producto->categoria_producto.' '.$producto->tipo_producto.' '.$producto->marca.' '.$producto->modelo.' '.$producto->color.'</td>'.
                            '<td class="text-left">'.$producto->nombre_sucursal.'</td>'.
                            '<td>'.$producto->existencia.'</td>'.
                            '<td class="text-right">$'.number_format($producto->precio_venta, 2).'</td>'.
                            '<td class="text-right">$'.number_format($producto->precio_venta*$producto->existencia, 2).'</td>'.
                            '</tr>';
                    }
                    elseif($producto->estatus == 0){
                        $result .= '<p class="card-title texte-center">El producto esta dado de baja</p>';
                        break;
                    }
                }
                return Response($result);
            }
        }
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

        $pdf = PDF::loadView('reportes.inventariopdf', compact('productos', 'fecha'));

        return $pdf->download('inventario_'.$fecha.'.pdf');
    }
}
