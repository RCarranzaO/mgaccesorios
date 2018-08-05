<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use mgaccesorios\DetalleAlmacen;
use mgaccesorios\Producto;
use mgaccesorios\Sucursal;
use mgaccesorios\Categoria;
use mgaccesorios\Tipo;
use mgaccesorios\Marca;


class AlmacenController extends Controller
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
     * Se hace la llamada a toda la informacion de la tabla Sucursal y por medio de la función join se utilizan los campos en las sucursales disponibles.
     * Luego, con el comando orderBy se ordena por id de manera ascendente.
     * Utilizando paginate(10) indicamos que nos debe mostrar 10 registros por página.
     * @return Regresa la vista de los productos y sus detalles en todas las sucursales.
     */
    public function index()
    {

        $sucursales = Sucursal::all();
        $productos = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
            ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
            ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
            ->select('detallealmacen.id_detallea','producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
            ->orderBy('detallealmacen.id_detallea')
            ->paginate(10);

        return view('reportes.inventario', compact('productos', 'sucursales'));
    }


    /**
     * La variable $sucursales llama a toda la informacion de la tabla Sucursal y la variable $productos llama a toda la infomracion de la tabla Producto.
     * @return Retorna la vista de un form donde podremos elegir el producto al que le daremos entrada y la sucursal en donde será asignada dicha entrada.
     */
    public function create()
    {
        $sucursales = Sucursal::all();
        $productos = DB::table('producto')
            ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
            ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
            ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
            ->select('producto.id_producto', 'producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'producto.estatus')
            ->orderBy('producto.id_producto')
            ->get();
        return view('entradas.compra', compact('sucursales', 'productos'));
    }


    /**
     * La funcion store valida la información solicitada en el form para darle entrada a un producto.
     * @param Los parámetros que se deben recibir son la referencia que es el identificador del producto, de tipo integer con un máximo de 255 caracteres, existencia que nos indica la cantidad del producto que va a ingresar, es de tipo integer y debe tener un valor mínimo de 1 y sucursal donde indicamos a que sucursal será asignada esa entrada de producto, es de tipo integer y con un máximo de 255 caracteres.
     * @return Nos redirige a almacen.index donde podemos visualizar los productos que han sido agregados exitosamente.
     */

    public function store(Request $request)
    {
        $producto = Producto::find($request->input('referencia'));
        $sucursal = Sucursal::find($request->input('sucursal'));

        $almacenes = DB::table('detallealmacen')
              ->where('id_producto',$request->input('referencia'))
              ->where('id_sucursal',$request->input('sucursal'))
              ->first();

        $validateData = $this->validate($request, [
            'referencia' => 'required|integer|max:255',
            'existencia' => 'required|integer|min:1',
            'sucursal' => 'required|integer|max:255|',
        ]);
        if (!$almacenes) {
            $almacen = new DetalleAlmacen();
            $almacen->id_producto = $request->input('referencia');
            $almacen->id_sucursal = $request->input('sucursal');
            $almacen->existencia = $request->input('existencia');
            $almacen->save();
        } else {
            $almacenId = DetalleAlmacen::find($almacenes->id_detallea);
            $almacenId->existencia = $almacenId->existencia + $request->input('existencia');
            $almacenId->save();
        }
        return redirect()->route('repalmacen')->with('success', 'Agregado correctamente!');
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

    public function destroy($id)
    {

    }

    /**
     * La función pdf llama a toda la información en la tabla detallealmacen de la base de datos y carga una vista de un documento en formato pdf con la fecha actual de cuando sehace la solicitud de la información
     * @return Devuelve la vista del documento con tod la información de los productos en el almacén y permite descargarla en un archivo con formato pdf.
     */
    public function pdf()
    {

        $productos = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
            ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
            ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
            ->select('producto.referencia', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia')
            ->get();
        $fecha = date('Y-m-d');

        $pdf = PDF::loadView('reportes.inventariopdf', compact('productos', 'fecha'));

        return $pdf->download('inventario_'.$fecha.'.pdf');
    }
}
