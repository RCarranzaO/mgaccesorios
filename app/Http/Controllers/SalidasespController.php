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
                    ->where('detallealmacen.id_sucursal', $usuario->id_sucursal)
                    ->get();
        //dd($salidas);
        $sucursales = Sucursal::all();
        return view('salidas.salidaesp', compact('sucursales', 'salidas'));
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
        $detalleaId = DetalleAlmacen::all()->where('id_producto', $id)->first();
        $date = Carbon::now();
        //dd($productoId);
        //dd($detalleaId);
        $max = $detalleaId->existencia;
        $validate = $this->validate($request, [
            'cantidad' => 'required|numeric',
            'descripcion' => 'required|string|max:255'
        ]);

        if ($request->input('cantidad')<=$max) {
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
            return redirect()->route('almacen.index');
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
