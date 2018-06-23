<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;

class SalidaespController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $salidas = SalidaEsp::all();
        return view('salidas.salidaesp', compat('salidas'));
    }
}
