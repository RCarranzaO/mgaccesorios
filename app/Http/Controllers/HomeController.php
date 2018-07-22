<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Fondo;
use Carbon\Carbon;

class HomeController extends Controller
{

    /**
     * La función function_construct se encarga de verificar que el usuario ha iniciado sesión antes de poder realizar cualquier acción.
     * @return Lo que devuelve es la autorización para entrar al sistema de Mg Acesorios.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * L afunción index se encarga de que al momento de iniciar sesión llama a variable fondo para designar el fondo de caja. 
     * @return Una vez asignado el fondo o si ya se había definido y se cierra la ventana para definir el fondo serás redirigido a la pantalla de home, que es la principal del software. 
     */
    public function index()
    {
        $date = Carbon::now();
        $date = $date->toDateString();
        $fondos = Fondo::all();
        $fondoId = $fondos->last();

        if (!$fondoId) {
            return redirect()->route('fondo');
        } elseif ($fondoId->fecha == $date) {
            return view('home');

        } elseif ($fondoId->fecha != $date) {
            return redirect()->route('fondo');
        }
    }
}
