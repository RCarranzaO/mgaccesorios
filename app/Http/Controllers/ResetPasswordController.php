<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * La funcion function _construct utilizando middleware verifica que el usuario que intenta accesar a la aplicación esté autenticado.
     * @return Si el usuario no es autenticado será regresado a la página de inicio de sesión.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected $redirectTo = '/login';

    /**
     * La función showResetForm despliega el formulario para reestablecer la contraseña.
     * @param El parámetro requerido es el correo validado a donde se enciará el correo para el reset de la contraseña. 
     * @param El parámetro requerido es el tóken que se generó para realizar el vínculo para el cambio de contraseña.
     * @return Devuelve la vista del formulario con los datos para reestablecer la contraseña.
     */
    public function showResetForm(Request $request, $token = null){
    	return view('auth/passwords/reset')->with(
    		['token' => $token, 'email' => $request->email]
    	);
    }

    /**
     * La función reset realiza la validación de los datos en el formulario para el reestablecimiento de la contraseña.
     * @param El parámetro que requiere es el formulario para reestablecer la contraseña. 
     * @return Regresa una respuesta a sendResetResponse para realizar el cambio de contraseña.
     */
    public function reset(Request $request){
    	$this->validate($request, $this->rules(), $this->validationErrorMessages());

    	$response = $this->broker()->reset(
    		$this->credentials($request), function ($user, $password) {
    			$this->resetPassword($user, $password);
    		}
    	);

    	return $response == Password::PASSWORD_RESET ? $this->sendResetResponse($response) : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * La funcion rules indica cuales son los campos requeridos para realizar el cambio de contraseña.
     * @return Lo que devuelve es el requerimiento del token generado, es decir que se debe haber ingresado por medio del enlace generado para el resetde la contraseña, el email al cual se le asigna la nueva contraseña y que la contraseña se haya ingresado y confirmado con un mínimo de 6 caracteres.
     */
    protected function rules(){
    	return[
    		'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|confirmed|min:6',
    	];
    }

    /**
    * La función validationErrorMessages se asegura de que no haya ningún error en la función para el reset de la contraseña.
    * @return No devuelve nada ya que solo es parte de la contrsuccion de Laravel.
    */    
    protected function validationErrorMessages(){
    	return [];
    }

    /**
     * La funcion credentials vuelve a confirmar que todos los parámetros requeridos sean correctos.
     * @param Los parámetros requeridos son el correo electrónico, la contraseña, la confirmación de esta contraseña y el token que permite el cambio de contraseña. 
     * @return Regresa una respuesta dependiendo de como proceda, erróneamente o correctamente.
     */
    protected function credentials(Request $request){
    	return $request->only(
    		'email', 'password', 'password_confirmation', 'token'
		);
    }

    /**
     * La funcion resetPassword realiza el cambio de contraseña, asigna esta contraseña al usuario y correos establecidos y por medio del Hash encripta la nueva contraseña.
     * @param El parámetro requerido es el usuario asignado a dicho correo y la nueva contraseña ya reestablecida. 
     * @return Una vez realizados los cambios nos redirige al sistema con la sesión ya iniciada.
     */
    protected function resetPassword($user, $password){
    	$user->password = Hash::make($password);
		$user->setRememberToken(Str::random(60));
		$user->save();
		event(new PasswordReset($user));
		$this->guard()->login($user);
    }

    /**
     * La funcion sendResetResponse se activa si toda la información solicitada previamente es correcta y permite el cambio de contraseña
     * @param El parámetro requerido es un response, el cual indica si la validación de los campos ha sido correcta. 
     * @return Lo que devuelve es la espuesta success indicando que todo a sido correcto.
     */
    protected function sendResetResponse($response){
    	return redirect($this->redirectPath())->with('success', trans($response));
    }

    /**
     * La función sendResetFailedResponse indica que se presentó algún error al realizar el reset de la contraseña
     * @param Los parámetros que requiere son el correo al cual se le está reestableciendo la contraseña y la respuesta indicando que se presentó un problema, el cual no permite guardar la nueva contraseña.
     * @return Devuelve una petición del correo al cual se intenta reestablecer la contraseña.
     */
    protected function sendResetFailedResponse(Request $request, $response){
    	return redirect()->back()->withInput($request->only('email'))->withErrors(['email' => trans($response)]);
    }

    /**
     * La funcion guard termina de realizar el cambio de contraseña guardando la información en el sistema.
     * @return No retorna ningún dato, solo realiza la actualización.
     */
    protected function guard(){
    	return Auth::guard();
    }

    /**
     * La función broker destruye la contraseña anterior.
     * @return No devuelve nada, solo realiza la destrucción de la contraseña que se tenía asignada previamente.
     */
    public function broker(){
    	return Password::broker();
    }

}
