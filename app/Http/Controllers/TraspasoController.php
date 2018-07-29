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
        //$salidas = DetalleAlmacen::all()->where('id_sucursal', $usuario->id_sucursal);
        $traspasos = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->select('producto.id_producto', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'detallealmacen.existencia', 'sucursales.id_sucursal', 'sucursales.nombre_sucursal', 'producto.estatus')
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
                    ->paginate(10);
        //dd($salidas);

        return view('traspaso.traspaso', compact('traspasos', 'sucursal'));
    }

    public function buscarT(Request $request)
    {
        if ($request->ajax()) {

            $result = "";
            $usuario = \Auth::user();

            if ($request->buscar == "") {
                $traspasos = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->select('producto.id_producto', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'detallealmacen.existencia', 'sucursales.id_sucursal')
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
                    ->paginate(10);
            }elseif ($request->buscar != "") {
                $traspasos = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->select('producto.id_producto', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'detallealmacen.existencia', 'sucursales.id_sucursal')
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
                    ->where(function ($query) use ($request){
                        $query->where('producto.referencia', 'like', '%'.$request->buscar.'%')
                            ->orWhere('producto.categoria_producto', 'like', '%'.$request->buscar.'%')
                            ->orWhere('producto.tipo_producto', 'like', '%'.$request->buscar.'%')
                            ->orWhere('producto.marca', 'like', '%'.$request->buscar.'%')
                            ->orWhere('producto.modelo', 'like', '%'.$request->buscar.'%')
                            ->orWhere('producto.color', 'like', '%'.$request->buscar.'%');
                    })
                    ->paginate(10);
            }
            if ($traspasos->count()) {
                foreach ($traspasos as $traspaso) {
                    $result.= '<tr>'.
                        '<td>'.$traspaso->referencia.'</td>'.
                        '<td>'.$traspaso->categoria_producto.', '.$traspaso->tipo_producto.', '.$traspaso->marca.', '.$traspaso->modelo.', '.$traspaso->color.'</td>'.
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
        //dd($detalleaId);
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
            //dd($traspaso);
            if ($detalleaID) {
                $detalleaId->existencia = $detalleaId->existencia - $request->input('cantidad');
                $detalleaID->existencia = $detalleaID->existencia + $request->input('cantidad');
                //dd($detalleaId);
                $detalleaId->save();
                $detalleaID->save();
            } else {

                $almacen = new DetalleAlmacen();
                $almacen->id_producto = $id;
                $almacen->id_sucursal = $request->input('sucursal');
                $almacen->existencia = $request->input('cantidad');
                $detalleaId->existencia = $detalleaId->existencia - $request->input('cantidad');
                //dd($detalleaId);
                $almacen->save();
                $detalleaId->save();
            }
            return redirect()->route('almacen.index')->with('success', 'El traspaso se realizo exitosamente');
        } else {
            return redirect()->route('traspaso.show', $id)->with('fail', 'La cantidad excede la existencia en el inventario');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Session::flash('id', $id);
        $usuario = \Auth::user();
        $sucursales = Sucursal::all();
        return view('traspaso.formtras', compact('id', 'sucursales', 'usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
