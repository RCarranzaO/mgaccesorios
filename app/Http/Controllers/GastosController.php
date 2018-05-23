<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;

class GastosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
