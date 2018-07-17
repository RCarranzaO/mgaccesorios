<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;

class EmailController extends Controller
{
	/**
	 * Description
	 * @param Request $request 
	 * @return type
	 */
    public function envio(Request $request)
    {
      Mail::send('email/password');
      return view ('Email/password');
    }
}
