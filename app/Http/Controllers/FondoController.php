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
        $user = \Auth::user();
        $fondoId = $fondos->last();
        return view('fondo.fondo', compact('fondoId', 'user'));
    }
    public function saveFondo(Request $request)
    {
        $validateData = $this->validate($request,[
            'cantidad' => 'required|numeric'
        ]);
        $fondos = Fondo::all();
        $fondo = new Fondo();
        $fondoId = $fondos->last();
        $user = \Auth::user();
        $date = Carbon::now();
        $date = $date->toDateString();
        //$date = new \DateTime();

        if ($fondoId->isEmpty()) {
            $fondo->id_user = $user->id_user;
            $fondo->cantidad = $request->input('cantidad');
            $fondo->fecha = $date;
            $fondo->save();
        } elseif ($fondoId->fecha == $date) {
            $fondoId->id_user = $user->id_user;
            $fondoId->cantidad = $request->input('cantidad');
            $fondoId->save();
        } else {
            $fondo->id_user = $user->id_user;
            $fondo->cantidad = $request->input('cantidad');
            $fondo->fecha = $date;
            $fondo->save();
        }
        //dd($fondoId);

        //$fondo->fecha = $date->format();

        return redirect()->route('guardar-saldo')->with(array(
            'message' => 'El fondo fue registrado'
        ));
    }
}
