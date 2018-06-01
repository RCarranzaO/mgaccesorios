<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Gasto;
use Carbon\Carbon;

class GastoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
      return view('gasto.gasto');
    }
    public function saveGasto(Request $request)
    {
        $validateData = $this->validate($request,[
            'cantidad' => 'required|numeric'
        ]);

        $gastos = new Gasto();
        $user = \Auth::user();
        $date = Carbon::now();
        //$date = new \DateTime();
        $gastos->id_fondo = $fondo->id_fondo;
        $gastos->descripcion = $request->input('descripcion');
        $gastos->cantidad = $request->input('cantidad');
        $gastos->fecha = $date;
        //$fondo->fecha = $date->format();
        $gastos->save();
        return redirect()->route('home')->with(array(
            'message' => 'Gasto registrado'
        ));
    }
}
