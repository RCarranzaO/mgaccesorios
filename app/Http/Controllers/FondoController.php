<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Fondo;
use Carbon\Carbon;
use mgaccesorios\Saldo;

class FondoController extends Controller
{
    /**
     * La función function_construct se encarga de verificar que el usuario ha iniciado sesión antes de poder realizar cualquier acción.
     * @return
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * La función index se encarga de la vista principal, al momento de haber iniciado sesión llama a la variable fondo para asignar el fondo de caja, le asigna un Id a ese fondo y guarda la infromación en la base de datos junto con el usuario que realizó la asignación del fondo de caja.
     * @return Retorna la vista del fondo donde se especificará el fondo de caja.
     */
    public function index()
    {
        $fondos = Fondo::all();
        $user = \Auth::user();
        $fondoId = $fondos->last();
        return view('fondo.fondo', compact('fondoId', 'user'));
    }

    /**
     * La función saveFondo se encarga de guardar la cantidad que se especifica como fondo de caja. Si la cantidad ingresada es errónea se puede volver a definir el fondo de caja, pero una vez realizado un cobro o retiro de caja este ya no puede ser modificado.
     * @param El parámetro requerido es el campo cantidad, el cual debe ser de tipo numérico.
     * @return Una vez asignado el fondo de caja devuelve un mensaje de confirmación para verificar que la cantidad es correcta.
     */
    public function saveFondo(Request $request)
    {
        $validateData = $this->validate($request,[
            'cantidad' => 'required|numeric'
        ]);
        $fondos = Fondo::all();
        $fondo = new Fondo();
        $saldoId = Saldo::all()->last();
        $fondoId = $fondos->last();
        $user = \Auth::user();
        $date = Carbon::now();
        $date = $date->toDateString();

        if (empty($fondoId)) {
            $fondo->id_user = $user->id_user;
            $fondo->id_sucursal = $user->id_sucursal;
            $fondo->cantidad = $request->input('cantidad');
            $fondo->fecha = $date;
            $fondo->save();
        } elseif ($saldoId->id_gasto!=null || $saldoId->id_cobro!=null || $saldoId->id_devolucion!=null){
            if ($saldoId->fecha == $date) {
                return redirect()->route('fondo')->with('fail','Ya se ha registrado una salida de dinero. El fondo de caja no puede ser modificado.');
            } elseif ($fondoId->fecha == $date) {
                $fondoId->id_user = $user->id_user;
                $fondoId->cantidad = $request->input('cantidad');
                $fondoId->save();
            } elseif ($fondoId->fecha != $date) {
                $fondo->id_user = $user->id_user;
                $fondo->id_sucursal = $user->id_sucursal;
                $fondo->cantidad = $request->input('cantidad');
                $fondo->fecha = $date;
                $fondo->save();
            }
        } else {
            $fondo->id_user = $user->id_user;
            $fondo->id_sucursal = $user->id_sucursal;
            $fondo->cantidad = $request->input('cantidad');
            $fondo->fecha = $date;
            $fondo->save();
        }

        return redirect()->route('guardarFondo');
    }
}
