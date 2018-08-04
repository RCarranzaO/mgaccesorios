<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Tipo;

class TipoController extends Controller
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
        $tipos = DB::table('tipos')
            ->paginate(10);

        return view('tipos.lista', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tipos.alta');
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
            'nombre' => 'required|string|max:20|unique:categorias',
        ]);

        $tipo = new Tipo();
        $tipo->nombre = $request->input('nombre');
        $tipo->estatus = $request->input('estatus');

        $tipo->save();

        return redirect()->route('home')->with('success', '¡El tipo de producto fue registrado correctamente!');
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
        $tipo = Tipo::find($id);
        return view('tipos/editar', compact('tipo', 'id_tipo'));
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
            'nombre' => 'required|string|max:20|unique:categorias',
        ]);

        $tipo = Tipo::find($id);
        $tipo->nombre = $request->input('nombre');
        $tipo->save();
        return redirect()->route('tipos.index')->with('success', '¡Tipo de producto actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipo = Tipo::find($id);
        
        if ($tipo->estatus == 1) {
            $tipo->estatus = 0;
        }else{
            $tipo->estatus = 1;
        }
        $tipo->save();
        return redirect()->route('tipos.index');
    }
}
