<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Password;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showForm(){
    	return view('auth/passwords/email');
    }
    
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

    protected function validateEmail(Request $request){
        $this->validate($request, ['email' => 'required|email']);
    }

    protected function broker(){
    	return Password::broker();
    }

}
