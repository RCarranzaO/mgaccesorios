<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;

class EntradasController extends Controller
{
  public function compra()
  {
    return view('Entradas/compra');
  }
}
