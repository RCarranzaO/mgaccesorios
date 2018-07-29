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

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id, Request $request)
    {
        if ($id!=NULL) {
            $result = "";
            $cobro = Cobro::all()->where('id_venta', $id);
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
            return Response($result);
        } else {
          return redirect()->route('devolucion.index');
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
