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
            ->select('producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia')
            ->get();
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
        $productos = Producto::all();
        $sucursales = Sucursal::all();

        $validateData = $this->validate($request, [
            'refproduc' => 'required|string|max:255',
            'exisproduc' => 'required|string|max:6',
            'sucproduc' => 'required|string|max:255',
        ]);

        $almacen = new DetalleAlmacen();
        $almacen->id_producto = $request->input('refproduc');
        $almacen->id_sucursal = $request->input('sucproduc');
        $almacen->existencia = $request->input('exisproduc');

        $almacen->save();

        switch ($request->input('action')) {
          case 'aya':
              return redirect()->route('almacen.create');
              break;

            case 'ays':
                return redirect()->route('home')->with('message', 'Se agregaron todos los productos al inventario');
                break;
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
        $sucursal = $request->input('sucursal');
        $sucursales = Sucursal::all();
        $sucursalId = Sucursal::find($request->input('sucursal'));
        $productos = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia');
          if ($sucursal==0) {
              $resultado = $productos->where('producto.referencia', 'like', '%'.$request->input('data').'%')
                                    ->orWhere('producto.categoria_producto', 'like', '%'.$request->input('data').'%')
                                    ->orWhere('producto.tipo_producto', 'like', '%'.$request->input('data').'%')
                                    ->orWhere('producto.marca', 'like', '%'.$request->input('data').'%')
                                    ->orWhere('producto.modelo', 'like', '%'.$request->input('data').'%')
                                    ->orWhere('producto.color', 'like', '%'.$request->input('data').'%');

          } else {
              $resultado = $productos->where('', 'pattern')
                                    ->where('producto.referencia', 'like', '%'.$request->input('data').'%')
                                    ->orWhere('producto.categoria_producto', 'like', '%'.$request->input('data').'%')
                                    ->orWhere('producto.tipo_producto', 'like', '%'.$request->input('data').'%')
                                    ->orWhere('producto.modelo', 'like', '%'.$request->input('data').'%')
                                    ->orWhere('producto.color', 'like', '%'.$request->input('data').'%');
          }

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
