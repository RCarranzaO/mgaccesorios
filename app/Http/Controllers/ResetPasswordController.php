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

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected $redirectTo = '/login';

    public function showResetForm(Request $request, $token = null){
    	return view('auth/passwords/reset')->with(
    		['token' => $token, 'email' => $request->email]
    	);
    }

    public function reset(Request $request){
    	$this->validate($request, $this->rules(), $this->validationErrorMessages());

    	$response = $this->broker()->reset(
    		$this->credentials($request), function ($user, $password) {
    			$this->resetPassword($user, $password);
    		}
    	);

    	return $response == Password::PASSWORD_RESET ? $this->sendResetResponse($response) : $this->sendResetFailedResponse($request, $response);
    }

    protected function rules(){
    	return[
    		'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|confirmed|min:6',
    	];
    }

    protected function validationErrorMessages(){
    	return [];
    }

    protected function credentials(Request $request){
    	return $request->only(
    		'email', 'password', 'password_confirmation', 'token'
		);
    }

    protected function resetPassword($user, $password){
    	$user->password = Hash::make($password);
		$user->setRememberToken(Str::random(60));
		$user->save();
		event(new PasswordReset($user));
		$this->guard()->login($user);
    }

    protected function sendResetResponse($response){
    	return redirect($this->redirectPath())->with('success', trans($response));
    }

    protected function sendResetFailedResponse(Request $request, $response){
    	return redirect()->back()->withInput($request->only('email'))->withErrors(['email' => trans($response)]);
    }

    protected function guard(){
    	return Auth::guard();
    }

    public function broker(){
    	return Password::broker();
    }

}
