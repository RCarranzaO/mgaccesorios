<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Password;

class ForgotPasswordController extends Controller
{
    /**
     * La funcion function _construct utilizando middleware verifica que el usuario que intenta accesar a la aplicación esté autenticado.
     * @return Si el usuario no es autenticado será regresado a la página de inicio de sesión.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * La función showForm realiza el llamado al archivo email.blade.php 
     * @return Se despliega la vista del formulario para reestablecer la contraseña. 
     */
    public function showForm(){
    	return view('auth/passwords/email');
    }
    
    /**
     * La función sendResetEmail envía el correo para poder cambiar la contraseña de inicio de sesión para el usuario del correo registrado en el formulario. 
     * @param El parámetro que solicita es un correo electrónico. 
     * @return Si el correo que se ingresó está registrado en el sistema se enviará el correo registrado un enlace para el reset de la contraseña.
     */
    public function sendResetEmail(Request $request){
    	$this->validateEmail($request);

    	$response = $this->broker()->sendResetLink(
    		$request->only('email')
    	);

    	if ($response == Password::RESET_LINK_SENT) {
    		return back()->with('success', trans($response));
    	}else{
    		return back()->with('fail', trans($response));
    	}

    }

    /**
     * La función calidateEmail verifica que el correo ingresado sea correcto y se encuentre registrado en labase de datos del sistema.
     * @param El parámetro que requiere es el email. 
     * @return Si el correo es ingresado de manera correcta permite a la función sendResetEmail enviar al correo ingresado el enlace para el reset de la contraseña
     */
    protected function validateEmail(Request $request){
        $this->validate($request, ['email' => 'required|email']);
    }

    /**
     * La funcion broker destruye la contraseña asignada al correo permitiendo asignar la nueva contraseña a este correo.
     */
    protected function broker(){
    	return Password::broker();
    }

}
