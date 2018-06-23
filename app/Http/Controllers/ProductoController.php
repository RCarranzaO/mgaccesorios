<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Producto;
use mgaccesorios\Usuario;

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
        $productos = Producto::all();
        return view('producto.producto', compact('productos'));
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
        $validateData = $this->validate($request,[
            'referencia' => 'required|string|unique:producto',
            'categoria' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
        ]);

        $producto = new Producto();
        $producto->referencia = $request->input('referencia');
        $producto->categoria_producto = $request->input('categoria');
        $producto->tipo_producto = $request->input('tipo');
        $producto->marca = $request->input('marca');
        $producto->modelo = $request->input('modelo');
        $producto->color = $request->input('color');
        $producto->precio_compra = $request->input('precio_compra');
        $producto->precio_venta = $request->input('precio_venta');
        $producto->estatus = $request->input('estatus');

        if ($producto->precio_venta < $producto->precio_compra) {
            return redirect()->back()->with('fail','Precio de venta invalido, debe ser mayor al de compra.');
        }else{
            $producto->save();
            return redirect()->route('producto.create')->with('success','Producto agregado.');
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
        $producto = Producto::find($id);
        return view('producto/editar', compact('producto', 'id_producto'));
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
        $this->validate($request,[
            'referencia' => 'required|string',
            'categoria' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
        ]);

        $producto = Producto::find($id);
        $producto->referencia = $request->input('referencia');
        $producto->categoria_producto = $request->input('categoria');
        $producto->tipo_producto = $request->input('tipo');
        $producto->marca = $request->input('marca');
        $producto->modelo = $request->input('modelo');
        $producto->color = $request->input('color');
        $producto->precio_compra = $request->input('precio_compra');
        $producto->precio_venta = $request->input('precio_venta');

        $producto->save();

        return redirect()->route('producto.index')->with('success', 'Producto actualizado!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);
        //$producto->estatus = '0';
        //dd($id);
        if ($producto->estatus == 1) {
            $producto->estatus = 0;
            $producto->save();
            return redirect()->route('producto.index')->with('success', 'Porducto dado de baja'.$producto);
        }elseif ($producto->estatus == 0){
            $producto->estatus = 1;
            $producto->save();
            return redirect()->route('producto.index')->with('success', 'Porducto dado de alta');
        }


    }

}
