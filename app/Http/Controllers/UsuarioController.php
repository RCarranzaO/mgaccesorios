<?php

namespace mgaccesorios\Http\Controllers;

use mgaccesorios\User;
use Illuminate\Http\Request;
use mgaccesorios\Sucursal;

class UsuarioController extends Controller
{

    /**
     * La función function_construct se encarga de verificar que el usuario ha iniciado sesión antes de poder realizar cualquier acción.
     * @return 
     */
    public function __construct()
    {

        $this->middleware('auth');

    }

    /**
     * La funcion index llama a toda la información de las tablas User y Sucursal de la base de datos.
     * @return Devuelve la vista de los usuarios registrados en la base de datos y a que sucursal pertenecen.
     */
    public function index()//Muestra la lista de usuarios registrados
    {

        $usuarios = User::all();
        $sucursales = Sucursal::all();
        return view('usuario/lista', compact('usuarios', 'sucursales'));

    }

    /**
     * La funcion create guarda la información del formulario para registrar a un nuevo usuario.
     * @return Devuelve la vista del formulario para la captura de información del nuevo usuario.
     */
    public function create()//Muestra el formulario para registrar un usuario nuevo
    {
        $sucursales = Sucursal::all();
        return view('usuario/registrar', compact('sucursales'));
    }

    /**
     * La funcion store valida la información capturada en el formulario para registrar a un nuevo usuario y la guarda.
     * @param Los parámetros requeridos para realizar el guardado de este formulario son los campos: name, apellido, username, email, password, rol y sucursal. 
     * @return Una vez validada la información y guardada nos redirrige a la vista home junto con un mensaje de success.
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
        
        return redirect()->route('home')->with('success', 'Usuario registrado correctamente!');
    }

    
    public function show($id)
    {
        
    }

    /**
     * La funcion edit permite ver y editar la información de un usuario seleccionado. Buscará en la tabla User al usuario seleccionado y en Sucursal, la sucursal a la que pertenece por medio del id:scursal relacionado al usuario.
     * @param El parámetro requerido es el id ya que cada botón de editar está relacionado con el id de ese usuario.
     * @return Devuelve la vista del formulario para editar la información de ese usuario.
     */
    public function edit($id)//Muestra la informacion a editar del usuario
    {
        $usuario = User::find($id);
        $sucursales = Sucursal::find($usuario->id_sucursal);
        $sucursalId = Sucursal::all();
        return view('usuario/editar', compact('usuario', 'id_user', 'sucursales', 'sucursalId'));
    }

    /**
     * La función update valida que la información del formulario esté correcta y completa, guarda los cambios realizados en la información del usuario seleccionado y actualiza la base de datos.
     * @param Los parámetros requeridos son: nombre, apellido, usuario, correo, password y rol. 
     * @param El parámetro id es requerido de la tabla sucursales ya que está relacionada con la tabla Users por medio del id de usuario.
     * @return Devuelve la vista de la lista del usuario.index. Los usuarios registrados en la base de datos.
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

        return redirect()->route('usuario.index')->with('success', 'Usuario actualizado!');

    }

    /**
     * La función destroy sirve para cambiar el estatus de un usuario de activo a inactivo por medio del valor 1 y 0 con los cuales indica su estado para restringir su acceso al sistema.
     * @param El parámetro que utiliza es el id, ya que el botón de cambio de estatus está relacionado al id del usuario al que desea modificar su estatus. 
     * @return Devuelve la vista del usuario.index con la lista de los ususarios registrados y su estatus actualizado.
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
