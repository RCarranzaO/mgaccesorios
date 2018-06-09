<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;

class EmailController extends Controller
{
    public function envio(Request $request)
    {
      Mail::send('email/password');
      return view ('Email/password');
    }
}
