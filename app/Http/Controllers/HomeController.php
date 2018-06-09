<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Fondo;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = Carbon::now();
        $date = $date->toDateString();
        $fondos = Fondo::all();
        $fondoId = $fondos->last();
        if ($fondoId->fecha == $date) {
            return view('home');

        } elseif ($fondoId->fecha != $date) {
            return redirect()->route('fondo');
        }
    }
}
