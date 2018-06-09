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

    public function lista()
    {
      $sucursales = Sucursal::all();
      return view('Sucursal/lista', compact('sucursales'));
    }

    public function destroy($id)
    {
      $sucursal = Sucursal::find($id);
      if ($sucursal->estatus == 1) {
          $sucursal->estatus == 0;
      }else{
          $sucursal->estatus = 1;
      }
      $sucursal->save();
      return redirect()->route('lista');
    }

}
