<?php

namespace mgaccesorios\Http\Controllers;

use mgaccesorios\Sucursal;
use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;

class SucursalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function alta()
    {
      return view('Sucursal/alta');
    }

    public function store(Request $request)
    {

        $sucursal = new Sucursal();
        $sucursal->nombre_sucursal = $request->input('nombre');
        $sucursal->direccion = $request->input('direccion');
        $sucursal->telefono = $request->input('telefono');
        $sucursal->estatus = $request->input('estatus');

        $sucursal->save();

        return redirect()->route('home');
    }

}
