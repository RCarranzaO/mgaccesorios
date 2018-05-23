<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Fondo;
use Carbon\Carbon;

class FondoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
      return view('fondo.fondo');
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
        return redirect()->route('home')->with(array(
            'message' => 'El fondo fue registrado'
        ));
    }
}
