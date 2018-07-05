<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Sucursal;

class BuscarController extends Controller
{

  /**
   * La función BuscarAlm permite buscar un producto específico en la sucursal seleccionada.
   * @param El parámetro requerido para realizar la busqueda es sucursal, se realiza la conexión con la tabla detallealmacen buscando según la información del campo deseado. Se hace un join entre el id_producto y id_sucursal para traer la información de las existencias en detallealmacen.
   * @return Al seleccionar una sucursal se muestra la información de los productos contenidos en dicha sucursal. Si el campo de busqueda sucursal está vacía, se mostrarán todos los productos todas las sucursales registradas.
   */
    public function BuscarA(Request $request)
    {
        if ($request->ajax()) {
            $result = "";
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
                          //->orWhere('producto.nombre_sucursal', 'like', '%'.$request->buscar.'%')
                          ->get();
            if ($productos) {
                foreach ($productos as $producto) {
                    if ($producto->estatus != 0) {
                        $result.= '<tr>'.
                            '<td>'.$producto->referencia.'</td>'.
                            '<td>'.$producto->categoria_producto.'</td>'.
                            '<td>'.$producto->tipo_producto.'</td>'.
                            '<td>'.$producto->marca.'</td>'.
                            '<td>'.$producto->modelo.'</td>'.
                            '<td>'.$producto->color.'</td>'.
                            '<td>$'.number_format($producto->precio_venta).'</td>'.
                            '<td>'.$producto->nombre_sucursal.'</td>'.
                            '<td>'.$producto->existencia.'</td>'.
                            '</tr>';
                    }
                    elseif($producto->estatus == 0){
                        $salida .= '<p class="card-title texte-center">El producto esta dado de baja</p>';
                        break;
                    }
                }
                return Response($result);
            }
        }
    }

    public function BuscarV(Request $request)
    {

        if ($request->ajax()) {
            $salida = "";
            $productos = DB::table('detallealmacen')
                          ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                          ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                          ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
                          ->orderBy('detallealmacen.id_detallea')
                          ->where('producto.referencia', 'like', '%'.$request->search.'%')
                          ->orWhere('producto.categoria_producto', 'like', '%'.$request->search.'%')
                          ->orWhere('producto.tipo_producto', 'like', '%'.$request->search.'%')
                          ->orWhere('producto.marca', 'like', '%'.$request->search.'%')
                          ->orWhere('producto.modelo', 'like', '%'.$request->search.'%')
                          ->orWhere('producto.color', 'like', '%'.$request->search.'%')
                          //->orWhere('producto.nombre_sucursal', 'like', '%'.$request->search.'%')
                          ->get();
            //dd($productos);
            if ($productos) {
                foreach ($productos as $producto) {
                    if ($producto->estatus != 0) {
                        $salida.= '<tr>'.
                            '<td>'.$producto->referencia.'</td>'.
                            '<td class="text-left">'.$producto->categoria_producto.' '.$producto->tipo_producto.' '.$producto->marca.' '.$producto->modelo.' '.$producto->color.'</td>'.
                            '<td class="text-left">'.$producto->nombre_sucursal.'</td>'.
                            '<td>'.$producto->existencia.'</td>'.
                            '<td class="text-right">$'.number_format($producto->precio_venta).'</td>'.
                            '<td><input type="number" id="cantidad" name="cantidad" style="width:50px"></td>'.
                            '<td>'.$producto->id_detallea.'</td>'.
                            '</tr>';
                    } elseif($producto->estatus == 0){
                        $salida .= '<p class="card-title texte-center">El producto esta dado de baja</p>';
                        break;
                    }
                }
                return Response($salida);
            }
        }
    }
}
