<?php

namespace mgaccesorios\Http\Controllers;

use mgaccesorios\User;
use Illuminate\Http\Request;
use mgaccesorios\Sucursal;

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
        $sucursales = Sucursal::all();
        return view('usuario/lista', compact('usuarios', 'sucursales'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()//Muestra el formulario para registrar un usuario nuevo
    {
        $sucursales = Sucursal::all();
        return view('usuario/registrar', compact('sucursales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)//Funcion que guarda al nuevo usuario
    {
        $validateData = $this->validate($request,[
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|string|max:255|unique:users',
            'password' => 'required|string|min:6|max:15|confirmed',
            'rol' => 'integer|required',
            'sucursal' => 'integer|required',
        ]);

        $usuario = new User();
        $usuario->name = $request->input('name');
        $usuario->lastname = $request->input('apellido');
        $usuario->username = $request->input('username');
        $usuario->email = $request->input('email');
        $usuario->password = bcrypt($request->input('password'));
        $usuario->rol = $request->input('rol');
        $usuario->id_sucursal = $request->input('sucursal');
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
    public function edit($id)//Muestra la informacion a editar del usuario
    {
        $usuario = User::find($id);
        $sucursales = Sucursal::find($usuario->id_sucursal);
        $sucursalId = Sucursal::all();
        return view('usuario/editar', compact('usuario', 'id_user', 'sucursales', 'sucursalId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)//Actualiza la informacion que se modifico del usuario
    {
        $this->validate($request,[
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'usuario' => 'required|string|max:255',
            'correo' => 'required|email|string|max:255',
            'password' => 'string|min:6|confirmed',
            'rol' => 'required|integer|max:2',
            'sucursal' => 'required|integer|max:6',
        ]);
        $usuario = User::find($id);
        $usuario->name = $request->input('nombre');
        $usuario->lastname = $request->input('apellido');
        $usuario->username = $request->input('usuario');
        $usuario->email = $request->input('correo');
        $usuario->password = bcrypt($request->input('password'));
        $usuario->rol = $request->input('rol');
        $usuario->id_sucursal = $request->input('sucursal');
        $usuario->save();
        switch ($request->input('action')) {
            case 'ays':
                return redirect()->route('home');
                break;

            case 'aym':
                return redirect()->route('usuario.index');
                break;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)//Activa o desactiva al usuario
    {
        $usuario = User::find($id);

        if ($usuario->estatus == 1) {
            $usuario->estatus = 0;
        }else{
            $usuario->estatus = 1;
        }
        $usuario->save();
        return redirect()->route('usuario.index');

    }
}
