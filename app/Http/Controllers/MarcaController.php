<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Marca;

class MarcaController extends Controller
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
        $marcas = DB::table('marcas')
            ->paginate(10);

        return view('marcas.lista', compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marcas.alta');
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
            'nombrem' => 'required|string|max:20|unique:marcas',
        ]);

        $marca = new Marca();
        $marca->nombrem = $request->input('nombrem');
        $marca->estatus = $request->input('estatus');

        $marca->save();

        return redirect()->route('home')->with('success', '¡La marca fue registrada correctamente!');
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
        $marca = Marca::find($id);
        return view('marcas/editar', compact('marca', 'id_marca'));
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
            'nombrem' => 'required|string|max:20|unique:marcas',
        ]);

        $marca = Marca::find($id);
        $marca->nombrem = $request->input('nombrem');
        $marca->save();
        return redirect()->route('marcas.index')->with('success', '¡Marca actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = Marca::find($id);
        
        if ($marca->estatus == 1) {
            $marca->estatus = 0;
        }else{
            $marca->estatus = 1;
        }
        $marca->save();
        return redirect()->route('marcas.index');
    }
}
