<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use mgaccesorios\Sucursal;

class SucursalController extends Controller
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
     * La función index apunta al archivo lista.blade.php.
     * @return Devuelve la vista de todas las sucursales registradas.
     */
    public function index()
    {
        $sucursales = Sucursal::all();
        return view('sucursal/lista', compact('sucursales'));
    }

    /**
     * La función create apunta al archivo alta.blade.php.
     * @return Devuelve la vista con el formulario para dar de alta una nueva sucursal.
     */
    public function create()
    {
        return view('sucursal/alta');
    }

    /**
     * La función store valida los campos del formulario para el alta de una nueva sucursal y guarda la informaciín en la base de datos del sistema.
     * @param Los parámetros requeridos son: nombre_sucursal, direccion, telefono y estatus. 
     * @return Si el registro se realiza de forma correcta se despliega un mensaje confirmando que el registro se ha realizado con éxito y nos redirige a la vista home. 
     */
    public function store(Request $request)
    {
        $validateData = $this->validate($request, [
            'nombre_sucursal' => 'required|string|max:255|unique:sucursales',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|min:7|max:13',
            'estatus' => 'required|numeric|max:2'
        ]);
        $sucursal = new Sucursal();
        $sucursal->nombre_sucursal = $request->input('nombre_sucursal');
        $sucursal->direccion = $request->input('direccion');
        $sucursal->telefono = $request->input('telefono');
        $sucursal->estatus = $request->input('estatus');
        $sucursal->save();

        return redirect()->route('home')->with('success', 'Sucursal registrada exitosamente');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    /**
     * La función destroy se encarga del estatus de las sucursales donde si el estatus es igual a 1, la sucursal está activa, lo cual significa que puede trabajar con normalidad.
     * Si el estatus es igual a 0, la sucursal está inactiva, lo cual significa que dicha sucursal no puede realizar movimientos.
     * @param El parámetro requerido es el id de la sucursal, el cual está ligado al botón Baja de cada sucursal en la lista de sucursales registradas.
     * @return Al cambiar el estatus de la sucural, nos redirige a la misma vista del index donde podemos ver el listado de las sucursales registradas con su estatus actualizado.
     */
    public function destroy($id)
    {
        $sucursal = Sucursal::find($id);
        if ($sucursal->estatus == 1) {
            $sucursal->estatus = 0;
        }else{
            $sucursal->estatus = 1;
        }
        $sucursal->save();
        return redirect()->route('sucursal.index');
    }
}
