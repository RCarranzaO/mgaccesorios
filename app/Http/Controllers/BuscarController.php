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
    public function BuscarAlm(Request $request)
    {
        $sucursales = Sucursal::all();
        //dd($request);
        $sucursalId = Sucursal::find($sucursales);
        $sucursal = $request->input('sucursal');
        $data = $request->input('data');
        $prod = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia');

        if ($sucursal==0) {
            $productos = DB::table('detallealmacen')
                          ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                          ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                          ->select('producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia')
                          ->where('producto.referencia', 'like', '%'.$data.'%')
                          ->orWhere('producto.categoria_producto', 'like', '%'.$data.'%')
                          ->orWhere('producto.tipo_producto', 'like', '%'.$data.'%')
                          ->orWhere('producto.marca', 'like', '%'.$data.'%')
                          ->orWhere('producto.modelo', 'like', '%'.$data.'%')
                          ->orWhere('producto.color', 'like', '%'.$data.'%')
                          ->get();
        } else {
            $productos = DB::table('detallealmacen')
                          ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                          ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                          ->select('producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia')
                          ->where('detallealmacen.id_sucursal',$sucursalId->id_sucursal)
                          ->get();
        }
        return view('almacen.almacen', compact('productos', 'sucursales'));
    }
}
