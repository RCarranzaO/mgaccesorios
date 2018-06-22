<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Validator;
use Auth;
use mgaccesorios\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    function index()
    {
    	 return view('auth/login');
    }

    function checklogin(Request $request)
    {

        $login = $request->input('login');

        //Comprueba si el input coincide con el formato de email
        $field = filter_var($login, FILTER_VALIDATE_EMAIL)? 'email':'username';
        $userId = User::where($field, '=', $login)->get();
      	$userData = array(
            $field => $login,
            'password' => $request->input('password')
      	);
        dd($userId);
      	if (Auth::attempt($userData)) {
            if ($userId->estatus != 0) {
                return redirect()->route('fondo');
            } else {
                return back()->with('fail', 'Usuario esta dado de baja');
            }
      	}else{
      		  return back()->with('fail', 'Información incorrecta.');
      	}
    }

    function logout()
    {
      	Auth::logout();
      	return redirect()->route('login');
    }
}
