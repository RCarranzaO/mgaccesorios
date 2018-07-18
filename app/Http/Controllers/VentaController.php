<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Venta;
use mgaccesorios\Sucursal;
use mgaccesorios\Cuenta;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $ventas = Venta::all();
        $venta = $ventas->last();
        $sucursales = Sucursal::all();
        $user = \Auth::user();
        $productos = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
            ->orderBy('detallealmacen.id_detallea')
            ->where('detallealmacen.id_sucursal', $user->id_sucursal)
            ->get();

        return view('venta.venta', compact('sucursales', 'user', 'venta', 'productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cart_temp(Request $request)
    {
        $user = \Auth::user();
        $cuenta = new Cuenta();
        $date = Carbon::now();
        //$venta = new Venta();
        //$venta->id_sucursal = $user->id_sucursal;
        //$venta->save();
        if($request->ajax()) {
            $result = "";
            $total = 0;
            //$venta->id_sucursal = $user->id_sucursal;
            $carrito = DB::table('detallealmacen')
                        ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                        ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                        ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
                        ->orderBy('detallealmacen.id_detallea')
                        ->where('detallealmacen.id_detallea', $request->id)
                        ->get();
                        //dd($carrito);
            if ($carrito) {
                $cuenta->id_venta = $request->venta;
                $cuenta->detallea = $carrito->id_detallea;
                $cuenta->cantidad = $request->cantidad;
                $cuenta->precio = $carrito->precio_venta*$request->cantidad;
                $cuenta->fecha = $date;
                foreach ($carrito as $cart) {
                    $result.= '<tr>'.
                              '   <td>'.$cart->referencia.'</td>'.
                              '   <td class="text-center">'.$request->cantidad.'</td>'.
                              '   <td>'.$cart->categoria_producto.', '.$cart->tipo_producto.', '.$cart->marca.', '.$cart->modelo.', '.$cart->color.'</td>'.
                              '   <td>$'.number_format($cart->precio_venta, 2).'</td>'.
                              '   <td>$'.number_format($cart->precio_venta*$request->cantidad, 2).'</td>'.
                              '   <td><a href="#" onclick="eliminar('.$cart->id_detallea.')">Eliminar</a></td>'.
                              '</tr>'.
                              '<tr>'.
                              '<td colspan="4">Neto $</td>'.
                              '<td>'.$total = number_format(($total + ($cart->precio_venta*$request->cantidad)), 2 ).'</td>'.
                              '<td></td>'.
                              '</tr>';
                }
                return Response($result);
            }
        }
    }
}
