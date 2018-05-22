<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;

class FondoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
      return view('fondo.fondo');
    }
}
