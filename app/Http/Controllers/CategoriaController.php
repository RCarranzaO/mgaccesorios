<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Categoria;

class CategoriaController extends Controller
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
     * La función index maneja las categorías de producto registradas.
     * @return Devuelve la vista de categorias.lista donde se muestran las categorías de productos registradas en la base de datos.
     */
    public function index()
    {
        $categorias = DB::table('categorias')
            ->paginate(10);

        return view('categorias.lista', compact('categorias'));
    }


    public function create()
    {
        return view('categorias.alta');
    }

    /**
     * La función store valida el campo nombrec y lo almacena en la base de datos.
     * @param El parámetro requerido es nombrec. 
     * @return Devuelve la vista de home con un mensaje de success indicando que se ha guardado la información de manera correcta.
     */
    public function store(Request $request)
    {
        $validateData = $this->validate($request,[
            'nombrec' => 'required|string|max:20|unique:categorias',
        ]);

        $categoria = new Categoria();
        $categoria->nombrec = $request->input('nombrec');
        $categoria->estatus = $request->input('estatus');

        $categoria->save();

        return redirect()->route('home')->with('success', '¡Categoria de producto registrada correctamente!');
    }


    public function show($id)
    {
        //
    }

    /**
     * La función edit permite modificar la información de la categoría de producto.
     * @param  El parámetro requerido es id, ya que el botón de editar está ligado al id de la categoría que desea modificar.
     * @return Devuelve la vista editar para cambiar el nombre de la categoría de producto.
     */
    public function edit($id)
    {
        $categoria = Categoria::find($id);
        return view('categorias/editar', compact('categoria', 'id_categoria'));
    }

    /**
     * La función update guarda los cambios realizados al editar la categoría y actualiza la base de datos.
     * @param La función realiza un request y valida el id de la categoría que modifica para realizar el update. 
     * @param El parámetro requerido es el id de categoría. 
     * @return Una vez realizada la actualización devuelve la vista categorias.index, la lista de categorías registradas en la base de datos junto con un mensaje de success indicando que se actualizó de forma correcta.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'nombrec' => 'required|string|max:20|unique:categorias',
        ]);

        $categoria = Categoria::find($id);
        $categoria->nombrec = $request->input('nombrec');
        $categoria->save();
        return redirect()->route('categorias.index')->with('success', '¡Categoría actualizada!');
    }

    /**
     * La funcion destroy controla el estatus de una categoría de producto para indicar si esta está activa o inactiva para su utilización.
     * @param El parámetro requerido es el id de categoria. 
     * @return Devuelve la lista de categorias.index, donde se muestran las categorías registradas en la base de datos con su estatus actualizados.
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        
        if ($categoria->estatus == 1) {
            $categoria->estatus = 0;
        }else{
            $categoria->estatus = 1;
        }
        $categoria->save();
        return redirect()->route('categorias.index');
    }
}
