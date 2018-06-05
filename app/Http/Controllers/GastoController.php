<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Gasto;
use Carbon\Carbon;
use mgaccesorios\Fondo;

class GastoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $fondos = Fondo::all();
        $fondoId = $fondos->last();
        return view('gasto.gasto', compact('fondoId'));
    }
    public function saveGasto(Request $request)
    {
        $validateData = $this->validate($request,[
            'cantidad' => 'required|numeric',
            'descripcion' => 'required|string|max:255'
        ]);

        $gastos = new Gasto();
        $fondo = Fondo::all();
        $fondoId = $fondo->last();
        $date = Carbon::now();
        //$date = new \DateTime();
        $gastos->id_fondo = $fondoId->id_fondo;
        $gastos->descripcion = $request->input('descripcion');
        $gastos->cantidad = $request->input('cantidad');
        $gastos->fecha = $date;
        //$fondo->fecha = $date->format();
        $gastos->save();

        return redirect()->route('guardar-saldo')->with(array(
            'message' => 'El gasto se registro!'
        ));
    }
}
