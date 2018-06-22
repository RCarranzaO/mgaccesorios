<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Validator;
use Auth;

class AuthController extends Controller
{
    function index(){
    	return view('auth/login');
    }

    function checklogin(Request $request){
    	$validateData = $this->validate($request, [
    		'email'		=> 'required|email',
    		'password' 	=> 'required|min:6' 
    	]);

    	$userData = array(
    		'email'		=> $request->get('email'),
    		'password'	=> $request->get('password')
    	);

    	if (Auth::attempt($userData)) {
    		return redirect()->route('home');
    	}else{
    		return back()->with('error', 'Información incorrecta.');
    	}
    }

    function logout(){
    	Auth::logout();
    	return redirect('');
    }
}
