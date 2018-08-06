<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Marca;

class MarcaController extends Controller
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
     * La función index maneja las marcas de producto registradas.
     * @return Devuelve la vista de marcas.lista donde se muestran las marcas de productos registradas en la base de datos.
     */
    public function index()
    {
        $marcas = DB::table('marcas')
            ->paginate(10);

        return view('marcas.lista', compact('marcas'));
    }

    /**
     * La función create maneja la vista de las altas de marcas.
     * @return Devuelve la vista de marcas.alta, el formulario para dar de alta una marca.
     */
    public function create()
    {
        return view('marcas.alta');
    }

    /**
     * La función store valida el campo nombrem y lo almacena en la base de datos.
     * @param El parámetro requerido es nombrem. 
     * @return Devuelve la vista de home con un mensaje de success indicando que se ha guardado la información de manera correcta.
     */
    public function store(Request $request)
    {
        $validateData = $this->validate($request,[
            'nombrem' => 'required|string|max:20|unique:marcas',
        ]);

        $marca = new Marca();
        $marca->nombrem = $request->input('nombrem');
        $marca->estatus = $request->input('estatus');

        $marca->save();

        return redirect()->route('home')->with('success', '¡La marca fue registrada correctamente!');
    }


    public function show($id)
    {
        //
    }

    /**
     * La función edit permite modificar la información de la marca de producto.
     * @param  El parámetro requerido es id, ya que el botón de editar está ligado al id de la marca que desea modificar.
     * @return Devuelve la vista editar para cambiar el nombre de la marca de producto.
     */
    public function edit($id)
    {
        $marca = Marca::find($id);
        return view('marcas/editar', compact('marca', 'id_marca'));
    }

    /**
     * La función update guarda los cambios realizados al editar la marca y actualiza la base de datos.
     * @param La función realiza un request y valida el id de la marca que modifica para realizar el update. 
     * @param El parámetro requerido es el id de marca.
     * @return Una vez realizada la actualización devuelve la vista marcas.index, la lista de marcas registradas en la base de datos junto con un mensaje de success indicando que se actualizó de forma correcta.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'nombrem' => 'required|string|max:20|unique:marcas',
        ]);

        $marca = Marca::find($id);
        $marca->nombrem = $request->input('nombrem');
        $marca->save();
        return redirect()->route('marcas.index')->with('success', '¡Marca actualizada!');
    }

    /**
     * La funcion destroy controla el estatus de una marca de producto para indicar si esta está activa o inactiva para su utilización.
     * @param El parámetro requerido es el id de marca. 
     * @return Devuelve la lista de marcas.index, donde se muestran las marcas registradas en la base de datos con su estatus actualizados.
     */
    public function destroy($id)
    {
        $marca = Marca::find($id);
        
        if ($marca->estatus == 1) {
            $marca->estatus = 0;
        }else{
            $marca->estatus = 1;
        }
        $marca->save();
        return redirect()->route('marcas.index');
    }
}
