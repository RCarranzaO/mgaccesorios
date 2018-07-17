<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Validator;
use Auth;
use mgaccesorios\User;

class AuthController extends Controller
{
    /**
     * La funcion function _construct utilizando middleware verifica que el usuario que intenta accesar a la aplicación esté autenticado.
     * @return Si el usuario no es autenticado será regresado a la página de inicio de sesión.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    function index()
    {
    	 return view('auth/login');
    }

    /**
     * La funcion checklogin solicita la informacion para el inicio de sesión y valida que el nombre del usuario o el correo con el que se intenta iniciar sesión coincidan con los registrados en la base de datos en la tabla User.
     * @param  Los parámetros solicitados para validar son email o username y password.
     * @return Si la validación falla por proporcionar información incorrecta regresa a la misma vista de inicio de sesión con el mensaje de error. 
     * Si la información es correcta al ser validada, se inicia la sesión de ese usuario y será redireccionado a la vista fondo.
     */
    function checklogin(Request $request)
    {

        $login = $request->input('login');

        //Comprueba si el input coincide con el formato de email
        $field = filter_var($login, FILTER_VALIDATE_EMAIL)? 'email':'username';
        $userId = User::where($field, $login)->first();
      	$userData = array(
            $field => $login,
            'password' => $request->input('password')
      	);

        if (!empty($userId->username) || !empty($userId->email)) {
            if ($userId->estatus == 1) {
                //dd($userId);
                if (Auth::attempt($userData)) {
                  //dd($userId);
                    return redirect()->route('fondo');
                }else{
                  //dd($userId);
                  //dd($userData);
                    return back()->with('fail', 'Información incorrecta.');
                }

            } elseif ($userId->estatus == 0) {
                return back()->with('fail', 'Usuario esta dado de baja');
            }
        }else{
            return back()->with('fail', 'El usuario no existe.');
        }



    }

    /**
     * La función logout realiza el cierre de sesión.
     * @return Al realizar el cierre de sesión será redireccionado a la vista del login. 
     */
    function logout()
    {
      	Auth::logout();
      	return redirect()->route('login');
    }
}
