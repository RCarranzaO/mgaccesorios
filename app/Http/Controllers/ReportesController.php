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
    
    /**
     * La función function_construct se encarga de verificar que el usuario ha iniciado sesión antes de poder realizar cualquier acción.
     * @return 
     */
    public function __construct()
    {
       $this->middleware('auth');
    }

    /**
     * La función index muestra los productos en el inventario.
     * @return Si el rol que realiza la búsqueda es Vendedor, solo se muestran los productos en la sucursal a  la que pertenece.
     Si el rol del usuario que realiza la búsqueda es Administrador, se muestran los productos de todas las sucursales disponibles en la base de datos.
     */
    public function index()
    {
        $user = \Auth::user();
        $sucursales = Sucursal::all();

        if ($user->rol == "1") {
            $productos = DB::table('detallealmacen')
                ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                ->select('detallealmacen.id_detallea', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.precio_venta', 'producto.estatus')
                ->orderBy('detallealmacen.id_detallea')
                ->paginate(10);
        }else{
            $productos = DB::table('detallealmacen')
                ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                ->select('detallealmacen.id_detallea', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.precio_venta', 'producto.estatus')
                ->orderBy('detallealmacen.id_detallea')
                ->where('sucursales.id_sucursal', '=', $user->id_sucursal)
                ->paginate(10);
        }
        return view('reportes.inventario', compact('productos', 'sucursales'));
    }

    /**
     * La función buscarR realiza una búsqueda de de un producto en específico en el inventario con forme se va escribiendo alguna característica del producto a buscar.
     * @param Se realiza una petición a la tabla detallealmacen para buscar los productos que cumplen con dicha característica.
     * @return Devuelve la vista de la lista de los productos que cumplen con las características que se van escribiendo.
     */
    public function buscarR(Request $request)
    {
        if ($request->ajax()) {

            $user = \Auth::user();
            $result = "";
            
            if ($request->buscador == "0" && $request->buscar == "" && $user->rol == "1") {
                $productos = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                    ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                    ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                    ->select('detallealmacen.id_detallea', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.precio_venta', 'producto.estatus')
                    ->orderBy('detallealmacen.id_detallea')
                    ->paginate(10);

            }elseif ($request->buscador == "0" && $request->buscar != "" && $user->rol == "1") {

                $productos = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                    ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                    ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                    ->select('detallealmacen.id_detallea', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.precio_venta', 'producto.estatus')
                    ->orderBy('detallealmacen.id_detallea')
                    ->where(function ($query) use ($request){
                        $query->where('producto.referencia', 'like', '%'.$request->buscar.'%')
                            ->orWhere('categorias.nombrec', 'like', '%'.$request->buscar.'%')
                            ->orWhere('tipos.nombret', 'like', '%'.$request->buscar.'%')
                            ->orWhere('marcas.nombrem', 'like', '%'.$request->buscar.'%')
                            ->orWhere('producto.modelo', 'like', '%'.$request->buscar.'%')
                            ->orWhere('producto.color', 'like', '%'.$request->buscar.'%');
                    })
                    ->paginate(10);

            }elseif ($request->buscador != "0" && $request->buscar == "") {

                $productos = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                    ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                    ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                    ->select('detallealmacen.id_detallea', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.precio_venta', 'producto.estatus')
                    ->orderBy('detallealmacen.id_detallea')
                    ->where('sucursales.id_sucursal', '=', $request->buscador)
                    ->paginate(10);

            }
            elseif ($request->buscador != "0" && $request->buscar != "") {

                $productos = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                    ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                    ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                    ->select('detallealmacen.id_detallea', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.precio_venta', 'producto.estatus')
                    ->orderBy('detallealmacen.id_detallea')
                    ->where('sucursales.id_sucursal', '=', $request->buscador)
                    ->where(function ($query) use ($request){
                        $query->where('producto.referencia', 'like', '%'.$request->buscar.'%')
                            ->orWhere('categorias.nombrec', 'like', '%'.$request->buscar.'%')
                            ->orWhere('tipos.nombret', 'like', '%'.$request->buscar.'%')
                            ->orWhere('marcas.nombrem', 'like', '%'.$request->buscar.'%')
                            ->orWhere('producto.modelo', 'like', '%'.$request->buscar.'%')
                            ->orWhere('producto.color', 'like', '%'.$request->buscar.'%');
                    })
                    ->paginate(10);

            }
            if ($productos->count()) {
                foreach ($productos as $producto) {
                    if ($producto->estatus != 0) {
                        $result.= '<tr>'.
                            '<td>'.$producto->referencia.'</td>'.
                            '<td>'.$producto->nombrec.'</td>'.
                            '<td>'.$producto->nombret.'</td>'.
                            '<td>'.$producto->nombrem.'</td>'.
                            '<td>'.$producto->modelo.'</td>'.
                            '<td>'.$producto->color.'</td>'.
                            '<td class="text-left">'.$producto->nombre_sucursal.'</td>'.
                            '<td>'.$producto->existencia.'</td>'.
                            '<td class="text-right">$'.number_format($producto->precio_venta, 2).'</td>'.
                            '<td class="text-right">$'.number_format($producto->precio_venta*$producto->existencia, 2).'</td>'.
                            '</tr>';
                    }
                    
                }
                return Response($result);
            }else{
                $result .= '<tr>'.
                    '<td colspan="10"><h3>No se encuentran registros de productos en la sucursal.</h3></td>'.
                    '</tr>';
                return Response($result);
            }
        }
    }

    /**
     * La función pdf permite imprimir en formato PDF la información solicitada de la tabla detallealmacen
     * @param Realiza un request a la base de datos con la información solicitada.
     * @return Devuelve la vista del inventario en formato PDF.
     */
    public function pdf(Request $request)
    {
        $fecha = date('Y-m-d');
        $user = \Auth::user();

        if ($request->buscador == "0" && $request->buscar == "" && $user->rol == "1") {
            $productos = DB::table('detallealmacen')
                ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                ->select('detallealmacen.id_detallea', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.precio_venta', 'producto.estatus')
                ->orderBy('detallealmacen.id_detallea')
                ->get();
                
        }elseif ($request->buscador == "0" && $request->buscar != "" && $user->rol == "1") {

            $productos = DB::table('detallealmacen')
                ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                ->select('detallealmacen.id_detallea', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.precio_venta', 'producto.estatus')
                ->orderBy('detallealmacen.id_detallea')
                ->where('producto.referencia', 'like', '%'.$request->buscar.'%')
                ->orWhere('categorias.nombrec', 'like', '%'.$request->buscar.'%')
                ->orWhere('tipos.nombret', 'like', '%'.$request->buscar.'%')
                ->orWhere('marcas.nombrem', 'like', '%'.$request->buscar.'%')
                ->orWhere('producto.modelo', 'like', '%'.$request->buscar.'%')
                ->orWhere('producto.color', 'like', '%'.$request->buscar.'%')
                ->get();
                
        }elseif ($request->buscador != "0" && $request->buscar == "") {

            $productos = DB::table('detallealmacen')
                ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                ->select('detallealmacen.id_detallea', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.precio_venta', 'producto.estatus')
                ->orderBy('detallealmacen.id_detallea')
                ->where('sucursales.id_sucursal', '=', $request->buscador)
                ->get();
                
        }elseif ($request->buscador != "0" && $request->buscar != "") {

            $productos = DB::table('detallealmacen')
                ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                ->select('detallealmacen.id_detallea', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.precio_venta', 'producto.estatus')
                ->orderBy('detallealmacen.id_detallea')
                ->where('sucursales.id_sucursal', '=', $request->buscador)
                ->where(function ($query) use ($request){
                    $query->where('producto.referencia', 'like', '%'.$request->buscar.'%')
                        ->orWhere('categorias.nombrec', 'like', '%'.$request->buscar.'%')
                        ->orWhere('tipos.nombret', 'like', '%'.$request->buscar.'%')
                        ->orWhere('marcas.nombrem', 'like', '%'.$request->buscar.'%')
                        ->orWhere('producto.modelo', 'like', '%'.$request->buscar.'%')
                        ->orWhere('producto.color', 'like', '%'.$request->buscar.'%');
                })
                ->get();
                
        }
        $pdf = PDF::loadView('reportes.inventariopdf', compact('productos', 'fecha'));
        return $pdf->download('inventario_'.$fecha.'.pdf');
        
    }
}
