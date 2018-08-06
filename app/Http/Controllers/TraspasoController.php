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
use mgaccesorios\Traspaso;

class TraspasoController extends Controller
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
     * La función index llama a los datos del usuario para registrar quien hace el traspaso d producto y llama todos los datos de la tabla detallealmacen de la sucursal donde ese usuario está registrado.
     * @return Devuelve la vista del archivo traspaso.blade.php con la información de los productos en la sucursal donde el usuario que desea realizar el traspaso está registrado.
     */
    public function index()
    {
        $usuario = \Auth::user();
        $sucursal = Sucursal::find($usuario->id_sucursal);
        $traspasos = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                    ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                    ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                    ->select('producto.id_producto', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'detallealmacen.existencia', 'sucursales.id_sucursal', 'sucursales.nombre_sucursal', 'producto.estatus')
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
                    ->paginate(10);

        return view('traspaso.traspaso', compact('traspasos', 'sucursal'));
    }

    /**
     * La función buscarT trabaja sobre la tabla detallealmacen llamando a todos sus campos para hacer la búsqueda de producto que se desea traspasar a otra sucursal. Realiza la validación de disponibilidad en la sucursal que realizará el traspaso hacia otra sucursal.
     * @param Se realiza un request a la base de datos, en la tabla detallealmacen y realiza la búsqueda del producto relacionado con la sucursal que realizará el traspaso. 
     * @return Devuelve la vista de la lista de productos en la sucursal que realizaó el traspaso junto con un mensaje de success indicando que el traspaso se realizó con éxito.
     */
    public function buscarT(Request $request)
    {
        if ($request->ajax()) {

            $result = "";
            $usuario = \Auth::user();

            if ($request->buscar == "") {
                $traspasos = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                    ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                    ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                    ->select('producto.id_producto', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'detallealmacen.existencia', 'sucursales.id_sucursal')
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
                    ->paginate(10);
            }elseif ($request->buscar != "") {
                $traspasos = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                    ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                    ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                    ->select('producto.id_producto', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'detallealmacen.existencia', 'sucursales.id_sucursal')
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
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
            if ($traspasos->count()) {
                foreach ($traspasos as $traspaso) {
                    $result.= '<tr>'.
                        '<td>'.$traspaso->referencia.'</td>'.
                        '<td>'.$traspaso->nombrec.', '.$traspaso->nombret.', '.$traspaso->nombrem.', '.$traspaso->modelo.', '.$traspaso->color.'</td>'.
                        '<td>'.$traspaso->existencia.'</td>'.
                        '<td><a href="'.route("traspaso.show", $traspaso->id_producto).'" class="btn btn-outline-info">Traspasar</a></td>'.
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
     * La función store guarda la información del inventario de las sucursales al realizar un traspaso. Valida el que la cantidad de producto sea correcta y la sucursal a donde se enviará el producto.
     * @param Se realiza un request a DetalleAlmacen para validar el producto que se desea traspasar a otra sucursal y la sucursal que recibirá dicho producto.
     * @return Si el traspaso se realiza con éxito devuelve la vista de almacen.index donde se podrá ver las existencias actualizadas de la sucursal que realizó el traspaso.
     * Si el traspaso no serealiza debido a que se indicó una cantidad errónea devuelve la vista de traspaso.show para poder definir una cantidad correcta a traspasar.
     */
    public function store(Request $request)
    {
        $traspaso = new Traspaso();
        $id = Session::get('id');
        $usuario = \Auth::user();
        $productoId = Producto::find($id);
        $detalleaId = DetalleAlmacen::all()
              ->where('id_producto', $id)
              ->where('id_sucursal', $usuario->id_sucursal)
              ->first();
        $detalleaID = DetalleAlmacen::all()
              ->where('id_producto', $id)
              ->where('id_sucursal', $request->input('sucursal'))
              ->first();
        $date = Carbon::now();
        $sucursalO = Sucursal::find($usuario->id_sucursal);
        $sucursalD = Sucursal::find($request->input('sucursal'));
        $max = $detalleaId->existencia;
        $validate = $this->validate($request, [
            'cantidad' => 'required|numeric',
            'sucursal' => 'required|numeric'
        ]);

        if ($request->input('cantidad') <= $max && $request->input('cantidad') > 0) {
            $traspaso->id_producto = $id;
            $traspaso->id_user = $usuario->id_user;
            $traspaso->sucursal_origen = $sucursalO->nombre_sucursal;
            $traspaso->sucursal_destino = $sucursalD->nombre_sucursal;
            $traspaso->cantidad = $request->input('cantidad');
            $traspaso->fecha = $date;
            $traspaso->save();
            if ($detalleaID) {
                $detalleaId->existencia = $detalleaId->existencia - $request->input('cantidad');
                $detalleaID->existencia = $detalleaID->existencia + $request->input('cantidad');
                $detalleaId->save();
                $detalleaID->save();
            } else {

                $almacen = new DetalleAlmacen();
                $almacen->id_producto = $id;
                $almacen->id_sucursal = $request->input('sucursal');
                $almacen->existencia = $request->input('cantidad');
                $detalleaId->existencia = $detalleaId->existencia - $request->input('cantidad');
                $almacen->save();
                $detalleaId->save();
            }
            return redirect()->route('almacen.index')->with('success', 'El traspaso se realizo exitosamente');
        } else {
            return redirect()->route('traspaso.show', $id)->with('fail', 'La cantidad excede la existencia en el inventario');
        }

    }

    /**
     * La función show se encarga de controlar el formulario para realizar el traspaso de producto.
     * @param El parámetro que requiere es el id del producto, ya que el botón de traspaso está ligado al producto que desea traspasar por su id. 
     * @return Devuelve la vista del formulario traspaso.formtras.
     */
    public function show($id)
    {
        Session::flash('id', $id);
        $usuario = \Auth::user();
        $sucursales = Sucursal::all();
        return view('traspaso.formtras', compact('id', 'sucursales', 'usuario'));
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
