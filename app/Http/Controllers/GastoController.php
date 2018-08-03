<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Gasto;
use Carbon\Carbon;
use mgaccesorios\Fondo;
use mgaccesorios\Saldo;

class GastoController extends Controller
{

    /**
     * La función function_construct se encarga de verificar que el usuario ha iniciado sesión antes de poder realizar cualquier acción.
     * @return type
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * La función index hace una llamada al archivo gasto.blade.php
     * @return Devuelve la vista del formulario para realizar un retiro de dinero de la caja.
     */
    public function index()
    {

        return view('gasto.gasto');
    }

    /**
     * La función saveGasto guarda la información de la cantidad de dinero que se va a retirar. Se debe especificar la cantidad y una descripción del porque se realiza dicho retiro de caja. El retiro se registra como un nuevo gasto, se resta del fondo de caja y se actualiza el fondo. Se guarda la información en la base de datos junto con la fecha en que se registra el retiro.
     * No es posible realizar un retiro mayor al saldo actual en caja ni realizar un retiro de dinero que deje el saldo de caja con menos de 500 pesos.
     * @param Los parámetros requeridos para el gaso son cantidad de tipo numérico y descripción de tipo string con un vaor máximo de 255 caracteres.
     * @return Si el retiro no se lleva acabo devuelve un mensaje de error indicando que la cnatidad que se desea retirar no está permitida.
     * Si el monto total a retirar es válido se guarda la información y nos redirecciona a la página principal del sistema Mg Accesorios.
     */
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
        $user = \Auth::user();

        if ($saldoId->fecha == $date) {
            if ($request->input('cantidad') >=0 && $request->input('cantidad') <= $saldoId->saldo_actual) {
                if (($saldoId->saldo_actual - $request->input('cantidad')) < 500) {
                    return redirect()->route('gasto')->with('fail', 'La cantidad a retirar no está permitida!');
                } else {
                    $gastos->id_fondo = $fondoId->id_fondo;
                    $gastos->descripcion = $request->input('descripcion');
                    $gastos->cantidad = $request->input('cantidad');
                    $gastos->id_sucursal = $user->id_sucursal; 
                    $gastos->fecha = $date;
                    $gastos->save();
                    return redirect()->route('guardarGasto');
                }
            } else {
                return redirect()->route('gasto')->with('fail', 'La cantidad a retirar no está permitida!');
            }
        } else {
            return redirect()->route('fondo')->with('fail', 'No se ha registrado un fondo el dia de hoy');
        }

    }
}
