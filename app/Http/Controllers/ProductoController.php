<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Producto;
use mgaccesorios\Usuario;

class ProductoController extends Controller
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
     * La función index apunta al archivo producto.blade.php.
     * @return Devuelve la vista de todos los productos que han sido registrados en la base de datos.
     */
    public function index()
    {

        $productos = DB::table('producto')
            ->paginate(10);

        return view('producto.producto', compact('productos'));
    }

    public function buscarP(Request $request)
    {
        if ($request->ajax()) {

            $result = "";

            if ($request->buscar != "") {

                $productos = DB::table('producto')
                    ->orderBy('producto.id_producto')
                    ->where('producto.referencia', 'like', '%'.$request->buscar.'%')
                    ->orWhere('producto.categoria_producto', 'like', '%'.$request->buscar.'%')
                    ->orWhere('producto.tipo_producto', 'like', '%'.$request->buscar.'%')
                    ->orWhere('producto.marca', 'like', '%'.$request->buscar.'%')
                    ->orWhere('producto.modelo', 'like', '%'.$request->buscar.'%')
                    ->orWhere('producto.color', 'like', '%'.$request->buscar.'%')
                    ->paginate(10);

            }elseif ($request->buscar == "") {
                $productos = DB::table('producto')
                    ->paginate(10);
            }
            if ($productos->count()) {
                foreach ($productos as $producto) {
                    $result.= '<tr>'.
                        '<td>'.$producto->referencia.'</td>'.
                        '<td>'.$producto->categoria_producto.'</td>'.
                        '<td>'.$producto->tipo_producto.'</td>'.
                        '<td>'.$producto->marca.'</td>'.
                        '<td>'.$producto->modelo.'</td>'.
                        '<td>'.$producto->color.'</td>'.
                        '<td>'.$producto->precio_compra.'</td>'.
                        '<td>'.$producto->precio_venta.'</td>'.
                        '<td><a'.'</td>'.
                        '</tr>';
                }
                return Response($result);
            }else{
                $result .= '<tr>'.
                    '<td colspan="11"><h3>No hay registros de productos.</h3></td>'.
                    '</tr>';
                return Response($result);
            }
        }
    }

    /**
     * La función create apunta al archivo alta.blade.php.
     * @return Develve la vista del formulario con los campos necesarios para registrar un producto en el sistema.
     */
    public function create()
    {
        return view('producto.alta');
    }

    /**
     * Con la función store se guarda la información del nuevo producto a registrar en la base de datos.
     * Para ello, se valida que se cumpla con el llenado de los campos: referencia, categoría, tipo, marca, modelo, color, precio_compra y precio_venta. Todos son campos de tipo string a excepción de precio_compra y precio_venta, los cuales son de tipo numérico y con un máximo de 255 caracteres.
     * La variable referencia es de tipo unique, impidiendo que existan duplicados del valor de referencia para cada producto.
     * También se define que el precio de venta no puede ser menor que el precio de compra para evitar pérdidas de efectivo por causa de un error de captura de información.
     * @param Losparámetros requeridos son todos los campos en la tabla Producto de la base de datos. Estos son: referencia, categoria, tipo, marca, modelo, color, precio_compra y precio_venta. 
     * @return Si estos campos no son llenados de manera correcta, se mostrará un mensaje de error indicando que el precio de venta debe ser mayor al precio de compra. 
     * Si los campos son completados de manera correcta, se mostrará un mensaje confirmándonos que el producto ha sido agregado.
     */
    public function store(Request $request)
    {
        $validateData = $this->validate($request,[
            'referencia' => 'required|string|unique:producto',
            'categoria' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
        ]);

        $producto = new Producto();
        $producto->referencia = $request->input('referencia');
        $producto->categoria_producto = $request->input('categoria');
        $producto->tipo_producto = $request->input('tipo');
        $producto->marca = $request->input('marca');
        $producto->modelo = $request->input('modelo');
        $producto->color = $request->input('color');
        $producto->precio_compra = $request->input('precio_compra');
        $producto->precio_venta = $request->input('precio_venta');
        $producto->estatus = $request->input('estatus');

        if ($producto->precio_venta < $producto->precio_compra) {
            return redirect()->back()->with('fail','Precio de venta invalido, debe ser mayor al de compra.');
        }else{
            $producto->save();
            return redirect()->route('producto.create')->with('success','Producto agregado.');
        }
    }

    public function show($id)
    {
        
    }

    /**
     * La función edit permite editar la información de el producto que seleccionemos.
     * @param El parámetro que pasamos para editar la información es $id.  
     * @return El botón de editar está ligado al id del producto que seleccionamos. Al seleccionar editar, se desplegará una vista con la información de ese producto para poder ser actualizada.
     */
    public function edit($id)
    {
        $producto = Producto::find($id);
        return view('producto/editar', compact('producto', 'id_producto'));
    }

    /**
     * La función update sirve para guardar los cambios que se hayan realizado en la información del producto seleccionado para su edición.
     * @param Los parámetros a validar son los campos referencia, categoria, tipo, marca, modelo, color, precio_compra y precio_venta. Todos son de tipo string con un valor máximo de 255 caracteres a excepión de precio_compra y precio_venta, los cuales son de tipo numérico. 
     * @param El parámetro $producto hace uso de Producto::find($id) para hacer referencia al producto seleccionado para editar y actualizará la información de los campos validados con la nueva información capturada. 
     * @return Al seleccionar el botón Aceptar, la función save() guardará la información del formulario y nos redirigirá a producto.index con la lista con los productos que están registrados junto con un mensaje de "Producto actualizado!" indicandonos que los cambios se han guardado con éxito.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'referencia' => 'required|string',
            'categoria' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
        ]);

        $producto = Producto::find($id);
        $producto->referencia = $request->input('referencia');
        $producto->categoria_producto = $request->input('categoria');
        $producto->tipo_producto = $request->input('tipo');
        $producto->marca = $request->input('marca');
        $producto->modelo = $request->input('modelo');
        $producto->color = $request->input('color');
        $producto->precio_compra = $request->input('precio_compra');
        $producto->precio_venta = $request->input('precio_venta');

        $producto->save();

        return redirect()->route('producto.index')->with('success', 'Producto actualizado!');

    }

    /**
     * La función destroy() se utiliza para cambiar el estatus de un producto. 
     * Si el valor del estatus es de 1, el estatus del producto es Activo.
     * Si el valor del estatus es de 0, el estatus del producto es Inactivo.
     * @param El parámetro utilizado es $id, con Producto::find($id) se realiza el cambio de estatus del producto cuyo id está relacionado con el botón para cambio de estatus. Cada botón está relacionado con el id de la misma fila en el cual está puesto.
     * @return Al hacer click en el botón cunado este dice Baja, el estatus es cambiado de Activo a Inactivo, indicando que el producto no puede ser utilizado para su compra o venta. Se mostrará un mensaje de confirmación indicando que el producto ha sido dado de baja.
     * Al hacer click en el botón cuando dice Alta, el estatus es cambiado de Inactivo a Activo, indicando que el producto se encuentra de nuevo disponible para su compra o venta. Se mostrará un mensaje de confirmación indicando que el producto ha sido dado de alta.
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);


        if ($producto->estatus == 1) {
            $producto->estatus = 0;
            $producto->save();
            return redirect()->route('producto.index')->with('success', 'Porducto dado de baja');
        }elseif ($producto->estatus == 0){
            $producto->estatus = 1;
            $producto->save();
            return redirect()->route('producto.index')->with('success', 'Porducto dado de alta');
        }
    
    }

}
