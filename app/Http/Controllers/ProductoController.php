<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
       $this->middleware('auth');
    }
    public function index()
    {
      $producto = Producto::all()->toArray();
      return view('producto.producto', compact('producto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('producto.alta');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
          'referencia'    => 'required',
          'categoria'     => 'required',
          'tipo'          => 'required',
          'marca'         => 'required',
          'modelo'        => 'required',
          'color'         => 'required',
          'precio_compra' => 'required',
          'precio_venta'  => 'required',
          'estatus'       => 'required'
      ]);
      $producto = new Producto([
          'referencia'    => $request->get('referencia'),
          'categoria'     => $request->get('categoria_producto'),
          'tipo'          => $request->get('tipo_producto'),
          'marca'         => $request->get('marca'),
          'modelo'        => $request->get('modelo'),
          'color'         => $request->get('color'),
          'precio_compra' => $request->get('precio_compra'),
          'precio_venta'  => $request->get('precio_venta'),
          'estatus'       => $request->get('estatus')
      ]);
      $producto->save();
      return redirect()->route('producto.producto')->with('success','Data Added');
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
