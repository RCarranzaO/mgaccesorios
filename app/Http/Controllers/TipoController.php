<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Tipo;

class TipoController extends Controller
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
     * La función index maneja los tipos de producto registrados.
     * @return Devuelve la vista de tipos.lista donde se muestran los tipos de productos registrados en la base de datos.
     */
    public function index()
    {
        $tipos = DB::table('tipos')
            ->paginate(10);

        return view('tipos.lista', compact('tipos'));
    }

    /**
     * La función create maneja la vista de las altas de tipos.
     * @return Devuelve la vista de tipos.alta, el formulario para dar de alta un tipo de producto.
     */
    public function create()
    {
        return view('tipos.alta');
    }

    /**
     * La función store valida el campo nombret y lo almacena en la base de datos.
     * @param El parámetro requerido es nombret.
     * @return Devuelve la vista de home con un mensaje de success indicando que se ha guardado la información de manera correcta.
     */
    public function store(Request $request)
    {
        $validateData = $this->validate($request,[
            'nombret' => 'required|string|max:20|unique:tipos',
        ]);

        $tipo = new Tipo();
        $tipo->nombret = $request->input('nombret');
        $tipo->estatus = $request->input('estatus');

        $tipo->save();

        return redirect()->route('home')->with('success', '¡El tipo de producto fue registrado correctamente!');
    }


    public function show($id)
    {
        //
    }

    /**
     * La función edit permite modificar la información del tipo de producto.
     * @param El parámetro requerido es id, ya que el botón de editar está ligado al id del tipo que desea modificar.
     * @return Devuelve la vista editar para cambiar el nombre del tipo de producto.
     */
    public function edit($id)
    {
        $tipo = Tipo::find($id);
        return view('tipos/editar', compact('tipo', 'id_tipo'));
    }

    /**
     * La función update guarda los cambios realizados al editar el tipo y actualiza la base de datos. 
     * @param La función realiza un request y valida el id del tipo que modifica para realizar el update en el mismo tipo de producto.
     * @param El parámetro requerido es el id del tipo. 
     * @return Una vez realizada la actualización devuelve la vista tipos.index, la lista de tipos registrados en la base de datos junto con un mensaje de success indicando que se actualizó de forma correcta.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'nombret' => 'required|string|max:20|unique:tipos',
        ]);

        $tipo = Tipo::find($id);
        $tipo->nombret = $request->input('nombret');
        $tipo->save();
        return redirect()->route('tipos.index')->with('success', '¡Tipo de producto actualizado!');
    }

    /**
     * La funcion destroy controla el estatus de un tipo de producto para indicar si este tipo está activo o inactivo para su utilización.
     * @param El parámetro requerido es el id del tipo. 
     * @return Devuelve la lista de tipos.index, donde se muestran los tipos registrados en la base de datos con su estatus actualizados.
     */
    public function destroy($id)
    {
        $tipo = Tipo::find($id);
        
        if ($tipo->estatus == 1) {
            $tipo->estatus = 0;
        }else{
            $tipo->estatus = 1;
        }
        $tipo->save();
        return redirect()->route('tipos.index');
    }
}
