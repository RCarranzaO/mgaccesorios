<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use mgaccesorios\DetalleAlmacen;
use mgaccesorios\Producto;
use mgaccesorios\Sucursal;

class AlmacenController extends Controller
{
    
    /**
     * Function construct funciona para impedir el acceso al Almacen sin haber iniciado sesion previamente.
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
     * @return Retorna la vista de los productos y sus detalles en todas las sucursales.
     */
    public function index()
    {
        /*$productoM = DB::table('producto')
            ->groupBy('marca')
            ->select('marca')
            ->get();*/
        $sucursales = Sucursal::all();
        $productos = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('detallealmacen.id_detallea','producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
            ->orderBy('detallealmacen.id_detallea')
            ->paginate(10);
        //dd($productos);
        return view('almacen.almacen', compact('productos', 'sucursales'));
    }


    /**
     * La variable $sucursales llama a toda la informacion de la tabla Sucursal y la variable $productos llama a toda la infomracion de la tabla Producto.
     * @return Retorna la vista de un form donde podremos elegir el producto al que le daremos entrada y la sucursal en donde será asignada dicha entrada.
     */
    public function create()
    {
        $sucursales = Sucursal::all();
        $productos = Producto::all();
        return view('entradas.compra', compact('sucursales', 'productos'));
    }

    
    /**
     * La funcion store valida la información solicitada en el form para darle entrada a un producto. 
     * @param Los parámetros que se deben recibir son la refproduc que es el identificador del producto, de tipo integer con un máximo de 255 caracteres, exisproduc que nos indica la cantidad del producto que va a ingresar, es de tipo integer y debe tener un valor mínimo de 1 y sucproduc donde indicamos a que sucursal será asignada esa entrada de producto, es de tipo integer y con un máximo de 255 caracteres. 
     * @return Nos redirige a almacen.index donde podemos visualizar los productos que han sido agregados exitosamente.
     */

    public function store(Request $request)
    {
        $producto = Producto::find($request->input('refproduc'));
        $sucursal = Sucursal::find($request->input('sucproduc'));
        /*$almacenes = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia')
            ->where('producto.referencia', $producto->referencia)
            ->where('sucursales.nombre_sucursal', $sucursal->nombre_sucursal)
            ->get();*/
        $almacenes = DB::table('detallealmacen')
              ->where('id_producto',$request->input('refproduc'))
              ->where('id_sucursal',$request->input('sucproduc'))
              ->first();
        //dd($almacenes->id_detallea);
        //dd($productos);
        $validateData = $this->validate($request, [
            'refproduc' => 'required|integer|max:255',
            'exisproduc' => 'required|integer|min:1',
            'sucproduc' => 'required|integer|max:255|',
        ]);
        if (!$almacenes) {
            $almacen = new DetalleAlmacen();
            $almacen->id_producto = $request->input('refproduc');
            $almacen->id_sucursal = $request->input('sucproduc');
            $almacen->existencia = $request->input('exisproduc');
            $almacen->save();
        } else {
            $almacenId = DetalleAlmacen::find($almacenes->id_detallea);
            $almacenId->existencia = $almacenId->existencia + $request->input('exisproduc');
            $almacenId->save();
        }
        return redirect()->route('almacen.index')->with('success', 'Agregado correctamente!');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
