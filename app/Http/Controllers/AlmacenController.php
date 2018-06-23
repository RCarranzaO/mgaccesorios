<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use mgaccesorios\DetalleAlmacen;
use mgaccesorios\Producto;
use mgaccesorios\Sucursal;

class AlmacenController extends Controller
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
        $productoM = DB::table('producto')
            ->groupBy('marca')
            ->select('marca')
            ->get();
        $sucursales = Sucursal::all();
        $productos = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('detallealmacen.id_detallea','producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia')
            ->paginate(10);
        return view('almacen.almacen', compact('productos', 'productoM', 'sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = Sucursal::all();
        $productos = Producto::all();
        return view('entradas.compra', compact('sucursales', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $producto = Producto::find($request->input('refproduc'));
        $sucursal = Sucursal::find($request->input('sucproduc'));
        /*$almacenes = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia')
            ->where('producto.referencia', $producto->referencia)
            ->where('sucursales.nombre_sucursal', $sucursal->nombre_sucursal)
            ->get();*/
        $almacenes = DB::table('detallealmacen')
              ->where('id_producto',$request->input('refproduc'))
              ->where('id_sucursal',$request->input('sucproduc'))
              ->first();
        //dd($almacenes->id_detallea);
        //dd($productos);
        $validateData = $this->validate($request, [
            'refproduc' => 'required|integer|max:255',
            'exisproduc' => 'required|integer|min:1',
            'sucproduc' => 'required|integer|max:255|',
        ]);
        if (!$almacenes) {
            $almacen = new DetalleAlmacen();
            $almacen->id_producto = $request->input('refproduc');
            $almacen->id_sucursal = $request->input('sucproduc');
            $almacen->existencia = $request->input('exisproduc');
            $almacen->save();
        } else {
            $almacenId = DetalleAlmacen::find($almacenes->id_detallea);
            $almacenId->existencia = $almacenId->existencia + $request->input('exisproduc');
            $almacenId->save();
        }
        return redirect()->route('almacen.index')->with('success', 'Agregado correctamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
