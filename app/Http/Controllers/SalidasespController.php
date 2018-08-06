<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use mgaccesorios\Sucursal;
use mgaccesorios\DetalleAlmacen;
use mgaccesorios\Producto;
use mgaccesorios\SalidaEsp;

class SalidasespController extends Controller
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
     * La función index realiza una búsqueda en la tabla detallealmacen de las existencias en la sucursal relacionada al usuario que realiza una salida especial. 
     * @return Devuelve la vista de salidas.slidaesp con la lista de los productos en esa sucursal.
     */
    public function index()
    {
        $usuario = \Auth::user();
        $sucursal = Sucursal::find($usuario->id_sucursal);
        $salidas = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                    ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                    ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                    ->select('producto.id_producto', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'detallealmacen.existencia', 'sucursales.id_sucursal')
                    ->orderBy('detallealmacen.id_detallea')
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
                    ->paginate(10);
        return view('salidas.salidaesp', compact('sucursal', 'salidas'));
    }

    /**
     * La función buscarS realiza un request al atabla detallealmacen para ver los productos registrados en la sucursal donde el usuario está realizando la salida especial.
     * @param El parámetro request solicita la información de los productos en la sucursal donde se está realizando la salida del producto. 
     * @return Devuelve la vista de la lista de productos disponibles pararealizar la salida especial de acuerdo a lo escrito en el buscador de producto.
     */
    public function buscarS(Request $request)
    {
        if ($request->ajax()) {

            $result = "";
            $usuario = \Auth::user();
            $sucursales = Sucursal::all();

            if ($request->buscar == "") {
                $salidas = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                    ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                    ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                    ->select('producto.id_producto', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'detallealmacen.existencia', 'sucursales.id_sucursal')
                    ->orderBy('detallealmacen.id_detallea')
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
                    ->paginate(10);
            }elseif ($request->buscar != "") {
                $salidas = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                    ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                    ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                    ->select('producto.id_producto', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'detallealmacen.existencia', 'sucursales.id_sucursal')
                    ->orderBy('detallealmacen.id_detallea')
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
                    ->where('producto.referencia', 'like', '%'.$request->buscar.'%')
                    ->paginate(10);
            }
            if ($salidas->count()) {
                foreach ($salidas as $salida) {

                    $result.= '<tr>'.
                        '<td>'.$salida->referencia.'</td>'.
                        '<td>'.$salida->nombrec.' '.$salida->nombret.' '.$salida->nombrem.' '.$salida->modelo.' '.$salida->color.'</td>'.
                        '<td>'.$salida->existencia.'</td>'.
                        '<td><a href="'.route("salidasesp.show", $salida->id_producto).'" class="btn btn-outline-info">Retirar</a></td>'.
                        '</tr>';
                }
                return Response($result);
            }else{
                $result .= '<tr>'.
                    '<td colspan="8"><h3>No se encuentran registros de productos.</h3></td>'.
                    '</tr>';
            }
        }
    }


    public function create()
    {
        //
    }

    /**
     * La función store valida la información del producto al que se le está dando salida y que los datos del formulario se hayan llenado de manera correcta para poder realizar la salida especial.
     * @param Los parámetros requeridos son: cantidad y descripcion. Se valida que la cantidad esté disponible y que el campo descripcion se haya llenado. 
     * @return Si la solicitud del producto es validada correctamente devuelve la vista almacen.index con un mensaje de success.
     * Si la validación es incorrecta devuelve la vista salidasesp.show con un mensaje de fail indicando que la cantidad solicitada excede las existencias.
     */
    public function store(Request $request)
    {
        $salidaesp = new SalidaEsp();
        $id = Session::get('id');
        $usuario = \Auth::user();
        $productoId = Producto::find($id);
        $detalleaId = DetalleAlmacen::all()
              ->where('id_producto', $id)
              ->where('id_sucursal', $usuario->id_sucursal)
              ->first();

        $date = Carbon::now();
        $max = $detalleaId->existencia;
        $validate = $this->validate($request, [
            'cantidad' => 'required|numeric',
            'descripcion' => 'required|string|max:255'
        ]);

        if ($request->input('cantidad') <= $max && $request->input('cantidad') > 0) {
            $salidaesp->id_sucursal = $usuario->id_sucursal;
            $salidaesp->id_producto = $id;
            $salidaesp->id_user = $usuario->id_user;
            $salidaesp->descripcion = $request->input('descripcion');
            $salidaesp->cantidad = $request->input('cantidad');
            $salidaesp->fecha = $date;
            $detalleaId->existencia = $detalleaId->existencia - $request->input('cantidad');
            $salidaesp->save();
            $detalleaId->save();
            return redirect()->route('almacen.index')->with('success', 'El traspaso se realizo exitosamente');
        } else {
            return redirect()->route('salidasesp.show', $id)->with('fail', 'La cantidad excede la existencia en el inventario');
        }

    }

    /**
     * La función show controla el formulario para realizar la salida especial.
     * @param El parámetro requerido es id, el botón retirar está ligado al id del producto que desea retirar. 
     * @return Devuelve salidas.formesp, que es la vista del formulario para realizar la salida especial.
     */
    public function show($id)
    {
        Session::flash('id', $id);
        return view('salidas.formesp', compact('id'));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
