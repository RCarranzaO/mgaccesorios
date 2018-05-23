<?php

namespace mgaccesorios\Http\Controllers;

use mgaccesorios\Usuario;
use mgaccesorios\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuario/registrar');
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
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'usuario' => 'required|string|unique:usuario'
        ]);

        $usuario = new Usuario();
        $usuario->name = $request->input('nombre');
        $usuario->lastname = $request->input('apellido');
        $usuario->username = $request->input('usuario');
        $usuario->email = $request->input('correo');
        $usuario->password = $request->input('password');
        $usuario->rol = $request->input('rol');
        $usuario->save();
        //return 'Guardado';
        //return $request->all();

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
