<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Devolucion;
use mgaccesorios\Cobro;
use mgaccesorios\Venta;

class DevolucionesController extends Controller
{

    public function index()
    {

        return view('devolucion/devolucion');
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $user = \Auth::user();
            //$cuenta = Cuenta::all()->where('id_venta', $request->venta);
            if ($request->tipo = "cambio") {
              // code...
            } elseif ($request->tipo = "devol") {
                $result = "";
                $ventas = DB::table('cuenta')
                    ->join('venta', 'cuenta.id_venta', '=', 'venta.id_venta')
                    ->join('cobro', 'cuenta.id_venta', '=', 'cobro.id_venta')
                    ->join('detallealmacen', 'cuenta.id_detallea', '=', 'detallealmacen.id_detallea')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->select('venta.id_venta', 'sucursales.nombre_sucursal', 'cuenta.id_detallea', 'cuenta.cantidad', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'cuenta.precio', 'cobro.monto_total')
                    ->where('cuenta.id_venta', $request->venta)
                    ->get();
                dd($ventas);
                foreach ($ventas as $dev) {
                    $result .='<table cellspacing="3">'.
                                  '<tr>'.
                                      '<td>'.$dev->cantidad.'</td>'.
                                      '<td>'.$dev->categoria_producto.' '.$dev->tipo_producto.' '.$dev->marca.'</td>'.
                                      '<td>'.$dev->precio.'</td>'.
                                      '<td><a href=# onclick="elminar('.$dev->id_detallea.')"><i class="fa fa-trash"></i></a></td>'.
                                  '</tr>'.
                              '</table>';
                }
                $result.= '<tr>'.
                          '   <td colspan="2">Neto $</td>'.
                          '   <td>'.number_format($dev->monto_total, 2 ).'</td>'.
                          '   <td></td>'.
                          '   <td></td>'.
                          '</tr>';
                dd($result);
                return Response($result);
            }


        }
    }

    public function store(Request $request)
    {

    }

    public function show($id, Request $request)
    {
        if ($id!=NULL) {
            $result = "";
            $ventas = DB::table('cuenta')
                ->join('venta', 'cuenta.id_venta', '=', 'venta.id_venta')
                ->join('cobro', 'cuenta.id_venta', '=', 'cobro.id_venta')
                ->join('detallealmacen', 'cuenta.id_detallea', '=', 'detallealmacen.id_detallea')
                ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                ->select('venta.id_venta', 'sucursales.nombre_sucursal', 'cuenta.id_detallea', 'cuenta.cantidad', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'cuenta.precio', 'cobro.monto_total')
                ->where('cuenta.id_venta', $id)
                ->get();
            foreach ($ventas as $dev) {
                $result .= '<tr>'.
                              '<td>'.$dev->cantidad.'</td>'.
                              '<td>'.$dev->categoria_producto.' '.$dev->tipo_producto.' '.$dev->marca.'</td>'.
                              '<td>'.$dev->precio.'</td>'.
                          '</tr>';
            }
            $result.= '<tr>'.
                      '   <td colspan="2">Neto $</td>'.
                      '   <td>'.number_format($dev->monto_total, 2 ).'</td>'.
                      '   <td></td>'.
                      '   <td></td>'.
                      '</tr>';
            return Response($result);
        }
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
