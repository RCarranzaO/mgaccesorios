<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Gasto;
use Carbon\Carbon;
use mgaccesorios\Fondo;
use mgaccesorios\Saldo;

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
            'cantidad' => 'required|numeric',
            'descripcion' => 'required|string|max:255'
        ]);

        $gastos = new Gasto();
        $saldoId = Saldo::all()->last();
        $fondo = Fondo::all();
        $fondoId = $fondo->last();
        $date = Carbon::now();
        $date = $date->toDateString();
        //$date = new \DateTime();

        if ($request->input('cantidad') >=0 && $request->input('cantidad') <= $saldoId->saldo_actual) {
            if (($saldoId->saldo_actual - $request->input('cantidad')) < 500) {
                return redirect()->route('gasto')->with('fail', 'La cantidad insertada no esta autorizada!');
            } else {
                $gastos->id_fondo = $fondoId->id_fondo;
                $gastos->descripcion = $request->input('descripcion');
                $gastos->cantidad = $request->input('cantidad');
                $gastos->fecha = $date;
                $gastos->save();
                return redirect()->route('guardarGasto');
            }
        } else {
            return redirect()->route('gasto')->with('fail', 'La cantidad insertada no es valida!');
        }
        //$fondo->fecha = $date->format();

    }
}
