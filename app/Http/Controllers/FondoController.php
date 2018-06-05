<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Fondo;
use Carbon\Carbon;
use mgaccesorios\Gasto;

class FondoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $fondos = Fondo::all();
        $fondoId = $fondos->last();
        return view('fondo.fondo', compact('fondoId'));
    }
    public function saveFondo(Request $request)
    {
        $validateData = $this->validate($request,[
            'cantidad' => 'required|numeric'
        ]);

        $fondo = new Fondo();
        $user = \Auth::user();
        $date = Carbon::now();
        //$date = new \DateTime();
        $fondo->id_user = $user->id_user;
        $fondo->cantidad = $request->input('cantidad');
        $fondo->fecha = $date;
        //$fondo->fecha = $date->format();
        $fondo->save();
        return redirect()->route('guardar-saldo')->with(array(
            'message' => 'El fondo fue registrado'
        ));
    }
}
