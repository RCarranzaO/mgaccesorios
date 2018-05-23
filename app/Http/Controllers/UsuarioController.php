<?php

namespace mgaccesorios\Http\Controllers;

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
    public function index()//Muestra la lista de usuarios registrados
    {

        $usuarios = User::all();

        return view('usuario/lista', compact('usuarios'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()//Muestra el formulario para registrar un usuario nuevo
    {
        return view('usuario/registrar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)//Guarda al nuevo usuario
    {
        $validateData = $this->validate($request,[
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'usuario' => 'required|string|max:255',
            'correo' => 'required|email|string|max:255',
            'password' => 'required|string|min:6|max:15|confirmed',
            'rol' => 'required|integer|max:2'
        ]);

        $usuario = new User();
        $usuario->name = $request->input('nombre');
        $usuario->lastname = $request->input('apellido');
        $usuario->username = $request->input('usuario');
        $usuario->email = $request->input('correo');
        $usuario->password = bcrypt($request->input('password'));
        $usuario->rol = $request->input('rol');
        $usuario->estatus = $request->input('estatus');
        $usuario->save();
        //return 'Guardado';
        //return $request->all();
        return redirect()->route('home');
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
    public function edit($id)//Muestra la informacion a cambiar del usuario
    {
        $usuario = User::find($id);
        return view('usuario/editar', compact('usuario', 'id_user'));
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
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'usuario' => 'required|string|max:255',
            'correo' => 'required|email|string|max:255',
            'password' => '|string|min:6|max:15|confirmed',
            'rol' => 'required|integer|max:2'
        ]);
        $usuario = User::find($id);
        $usuario->name = $request->input('nombre');
        $usuario->lastname = $request->input('apellido');
        $usuario->username = $request->input('usuario');
        $usuario->email = $request->input('correo');
        $usuario->password = bcrypt($request->input('password'));
        $usuario->rol = $request->input('rol');
        $usuario->save();
        return redirect()->route('home');
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
