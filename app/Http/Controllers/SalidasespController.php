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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = \Auth::user();

        //$salidas = DetalleAlmacen::all()->where('id_sucursal', $usuario->id_sucursal);
        $salidas = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->select('producto.id_producto', 'producto.referencia', 'detallealmacen.existencia', 'sucursales.id_sucursal')
                    ->orderBy('detallealmacen.id_detallea')
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
                    ->paginate(10);
        //dd($salidas);
        $sucursales = Sucursal::all();
        return view('salidas.salidaesp', compact('sucursales', 'salidas'));
    }

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
                    ->select('producto.id_producto', 'producto.referencia', 'detallealmacen.existencia', 'sucursales.id_sucursal')
                    ->orderBy('detallealmacen.id_detallea')
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
                    ->paginate(10);
            }elseif ($request->buscar != "") {
                $salidas = DB::table('detallealmacen')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->select('producto.id_producto', 'producto.referencia', 'detallealmacen.existencia', 'sucursales.id_sucursal')
                    ->orderBy('detallealmacen.id_detallea')
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
                    ->where('producto.referencia', 'like', '%'.$request->buscar.'%')
                    ->paginate(10);
            }
            if ($salidas->count()) {
                foreach ($salidas as $salida) {

                    $result.= '<tr>'.
                        '<td>'.$salida->referencia.'</td>'.
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
        $salidaesp = new SalidaEsp();
        $id = Session::get('id');
        $usuario = \Auth::user();
        $productoId = Producto::find($id);
        $detalleaId = DetalleAlmacen::all()
              ->where('id_producto', $id)
              ->where('id_sucursal', $usuario->id_sucursal)
              ->first();

        $date = Carbon::now();
        //dd($productoId);
        //dd($detalleaId);
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
            //dd($salidaesp);
            $salidaesp->save();
            $detalleaId->save();
            return redirect()->route('almacen.index')->with('success', 'El traspaso se realizo exitosamente');
        } else {
            return redirect()->route('salidasesp.show', $id)->with('fail', 'La cantidad excede la existencia en el inventario');
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
        //dd($id);
        Session::flash('id', $id);
        return view('salidas.formesp', compact('id'));
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
