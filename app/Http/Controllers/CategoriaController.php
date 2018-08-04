<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Categoria;

class CategoriaController extends Controller
{

    /**
     * La función function_construct se encarga de verificar que el usuario ha iniciado sesión antes de poder realizar cualquier acción.
     * @return type
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
        $categorias = DB::table('categorias')
            ->paginate(10);

        return view('categorias.lista', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias.alta');
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
            'nombrec' => 'required|string|max:20|unique:categorias',
        ]);

        $categoria = new Categoria();
        $categoria->nombrec = $request->input('nombrec');
        $categoria->estatus = $request->input('estatus');

        $categoria->save();

        return redirect()->route('home')->with('success', '¡Categoria de producto registrada correctamente!');
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
        $categoria = Categoria::find($id);
        return view('categorias/editar', compact('categoria', 'id_categoria'));
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
            'nombrec' => 'required|string|max:20|unique:categorias',
        ]);

        $categoria = Categoria::find($id);
        $categoria->nombrec = $request->input('nombrec');
        $categoria->save();
        return redirect()->route('categorias.index')->with('success', '¡Categoría actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        
        if ($categoria->estatus == 1) {
            $categoria->estatus = 0;
        }else{
            $categoria->estatus = 1;
        }
        $categoria->save();
        return redirect()->route('categorias.index');
    }
}
