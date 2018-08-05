<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Venta;
use mgaccesorios\Sucursal;
use mgaccesorios\Cuenta;
use mgaccesorios\Cobro;
use mgaccesorios\Fondo;
use mgaccesorios\DetalleAlmacen;
use Carbon\Carbon;
use Session;

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
        $venta = Venta::all()->last();
        $fondo = Fondo::all()->last();
        $sucursales = Sucursal::all();
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $user = \Auth::user();
        $total = 0;
        $articulos = 0;
        $productos = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
            ->orderBy('detallealmacen.id_detallea')
            ->where('detallealmacen.id_sucursal', $user->id_sucursal)
            ->get();
        if (empty($venta)) {
            return view('venta.venta', compact('sucursales', 'user', 'date', 'productos'));
        } else {
            $ventas = DB::table('cuenta')
                ->join('venta', 'cuenta.id_venta', '=', 'venta.id_venta')
                ->join('cobro', 'cuenta.id_venta', '=', 'cobro.id_venta')
                ->join('detallealmacen', 'cuenta.id_detallea', '=', 'detallealmacen.id_detallea')
                ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                ->select('venta.id_venta', 'sucursales.nombre_sucursal', 'cuenta.id_detallea', 'cuenta.cantidad', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'cuenta.precio', 'cobro.monto_total')
                ->where('cuenta.id_venta', $venta->id_venta)
                ->get();
            foreach ($ventas as $vent) {
                $articulos = $articulos+$vent->cantidad;
            }
            if ($venta->estatus == NULL) {
                $cuentas = DB::table('cuenta')
                    ->join('detallealmacen', 'cuenta.id_detallea', '=', 'detallealmacen.id_detallea')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->select('cuenta.id_cuenta', 'cuenta.id_venta', 'cuenta.id_detallea', 'detallealmacen.id_producto', 'detallealmacen.existencia', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'cuenta.cantidad', 'cuenta.precio', 'producto.precio_venta', 'cuenta.fecha')
                    ->where('cuenta.id_venta', $venta->id_venta)
                    ->get();
                foreach ($cuentas as $cuenta) {
                    $total = $total + $cuenta->precio;
                }
            }
            if (empty($fondo->fecha)) {
                return view('fondo.fondo', compact('fondo', 'user'))->with('fail', 'No se puede realizar una venta, aún no se ha ingresado un fondo');
            } elseif ($fondo->fecha != $fecha) {
                return view('fondo.fondo', compact('fondo', 'user'))->with('fail', 'No se puede realizar una venta, aún no se ha ingresado un fondo');
            } else {
                $cobro = Cobro::all()->where('id_venta', $venta->id_venta);
                return view('venta.venta', compact('sucursales', 'user', 'venta', 'productos', 'cuentas', 'articulos', 'ventas', 'cobro', 'total', 'date'));
            }
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $cuentas = Cuenta::all()->where('id_venta', $request->id);
            $almacenes = DetalleAlmacen::all();
            $venta = Venta::find($request->id);
            $user = \Auth::user();
            $cobrar = new Cobro();
            $cobro = Cobro::all()->last();
            $total = 0;
            $date = Carbon::now()->toDateString();
            foreach ($cuentas as $cuenta) {
                $almacen = $almacenes->where('id_detallea', $cuenta->id_detallea);
                foreach ($almacen as $alma) {
                    $alma->existencia = $alma->existencia - $cuenta->cantidad;
                    $alma->save();
                }
                $total = $total + $cuenta->precio;
            }
            if (empty($cobro)) {
                $cobrar->id_venta = $request->id;
                $cobrar->id_user = $user->id_user;
                $cobrar->id_sucursal = $user->id_sucursal;
                $cobrar->monto_total = $total;
                $cobrar->fecha = $date;
                $venta->estatus = 1;
                $cobrar->save();
                $venta->save();
                return redirect()->route('guardarCobro')->with('success', 'Venta realizada correctamente');
            }elseif ($cobro->id_venta != $venta->id_venta) {
                $cobrar->id_venta = $request->id;
                $cobrar->id_user = $user->id_user;
                $cobrar->id_sucursal = $user->id_sucursal;
                $cobrar->monto_total = $total;
                $cobrar->fecha = $date;
                $venta->estatus = 1;
                $cobrar->save();
                $venta->save();
                return redirect()->route('guardarCobro')->with('success', 'Venta realizada correctamente');
            } elseif ($cobro->id_venta != $venta->id_venta) {
                return redirect()->route('venta.index')->with('fail', 'El N° de venta ya existe');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($request->ajax()) {
            $result = '';
            $total = 0;
            $cuentas = DB::table('cuenta')
                        ->join('detallealmacen', 'cuenta.id_detallea', '=', 'detallealmacen.id_detallea')
                        ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                        ->select('cuenta.id_cuenta', 'cuenta.id_venta', 'cuenta.id_detallea', 'detallealmacen.id_producto', 'detallealmacen.existencia', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'cuenta.cantidad', 'cuenta.precio', 'producto.precio_venta', 'cuenta.fecha')
                        ->where('cuenta.id_venta', $request->venta)
                        ->get();
            foreach ($cuentas as $cart) {
                $result.= '<tr>'.
                          '   <td>'.$cart->referencia.'</td>'.
                          '   <td class="text-center"><input type="number" min="1" max="'.$cart->existencia.'" id="cantidad_'.$cart->id_cuenta.'" class="text-center" style="width:50px" value="'.$cart->cantidad.'"></td>'.
                          '   <td>'.$cart->categoria_producto.', '.$cart->tipo_producto.', '.$cart->marca.', '.$cart->modelo.', '.$cart->color.'</td>'.
                          '   <td>$'.number_format($cart->precio_venta, 2).'</td>'.
                          '   <td>$'.number_format($cart->precio, 2).'</td>'.
                          '   <td><a href="#" class="" onclick="eliminar('.$cart->id_cuenta.')"><i class="fa fa-trash"></i></a></td>'.
                          '</tr>';
                $total = ($total + $cart->precio);
            }
            $result.= '<tr>'.
                      '   <td colspan="4">Neto $</td>'.
                      '   <td>'.number_format($total, 2 ).'</td>'.
                      '   <td></td>'.
                      '</tr>';
            //dd($result);
            return Response($result);
        }

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
    public function destroy($id, Request $request)
    {
        $cuenta = Cuenta::find($id);
        $result = '';
        if ($request->ajax()) {
            if ($request->cantidad < $cuenta->cantidad && $request->cantidad > 0) {
                $cuenta->precio = $cuenta->precio - (($cuenta->precio/$cuenta->cantidad)*$request->cantidad);
                $cuenta->cantidad = $cuenta->cantidad - $request->cantidad;
                $cuenta->save();
            } elseif ($request->cantidad == $cuenta->cantidad) {
                $cuenta->delete();
            } elseif ($request->cantidad > $cuenta->cantidad) {
                $result .= '<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                Existencias insufcientes!
                            </div>';
                return Response($result);
            }
        }
        //dd($cuenta);
        return Response($cuenta);
    }

    public function cart_temp(Request $request)
    {
        $user = \Auth::user();
        $cuenta = new Cuenta();
        $date = Carbon::now()->toDateString();
        $ventas = Venta::all()->last();
        $venta = new Venta();
        //dd($ventas);
        $validateData = $this->validate($request,[
            'cantidad' => 'required|numeric|min:1'
        ]);
        if($request->ajax()) {
            $result = '';
            $total = 0;
            $carrito = DB::table('detallealmacen')
                        ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                        ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                        ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
                        ->where('detallealmacen.id_detallea', $request->id)
                        ->first();
            //dd($carrito);
            if ($carrito) {
                if ($request->cantidad <= $carrito->existencia) {
                    if(empty($ventas)){
                        $venta->id_sucursal = $user->id_sucursal;
                        $venta->save();
                        $cuenta->id_venta = $venta->id_venta;
                        $cuenta->id_detallea = $carrito->id_detallea;
                        $cuenta->cantidad = $request->cantidad;
                        $cuenta->precio = $carrito->precio_venta*$request->cantidad;
                        $cuenta->fecha = $date;
                        $cuenta->save();
                    } elseif($ventas->estatus == 1){
                        $venta->id_sucursal = $user->id_sucursal;
                        $venta->save();
                        $cuenta->id_venta = $venta->id_venta;
                        $cuenta->id_detallea = $carrito->id_detallea;
                        $cuenta->cantidad = $request->cantidad;
                        $cuenta->precio = $carrito->precio_venta*$request->cantidad;
                        $cuenta->fecha = $date;
                        $cuenta->save();
                    } elseif ($ventas->estatus == NULL) {
                        $cuenta->id_venta = $ventas->id_venta;
                        $cuenta->id_detallea = $carrito->id_detallea;
                        $cuenta->cantidad = $request->cantidad;
                        $cuenta->precio = $carrito->precio_venta*$request->cantidad;
                        $cuenta->fecha = $date;
                        $cuenta->save();
                    } elseif ($ventas->estatus == 0) {
                        return redirect()->route('venta.index')->with('fail', 'La venta esta cancelada');
                    }
                }
                $venta = Venta::all()->last();
                $cuentas = DB::table('cuenta')
                            ->join('detallealmacen', 'cuenta.id_detallea', '=', 'detallealmacen.id_detallea')
                            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                            ->select('cuenta.id_cuenta', 'cuenta.id_venta', 'cuenta.id_detallea', 'detallealmacen.id_producto', 'detallealmacen.existencia', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'cuenta.cantidad', 'cuenta.precio', 'producto.precio_venta', 'cuenta.fecha')
                            ->where('cuenta.id_venta', $venta->id_venta)
                            ->get();
                //dd($cuentas);
                foreach ($cuentas as $cart) {
                    $result.= '<tr>'.
                              '   <td>'.$cart->referencia.'</td>'.
                              '   <td class="text-center"><input type="number" min="1" max="'.$cart->existencia.'" id="cantidad_'.$cart->id_cuenta.'" class="text-center" style="width:50px" value="'.$cart->cantidad.'"></td>'.
                              '   <td>'.$cart->categoria_producto.', '.$cart->tipo_producto.', '.$cart->marca.', '.$cart->modelo.', '.$cart->color.'</td>'.
                              '   <td>$'.number_format($cart->precio_venta, 2).'</td>'.
                              '   <td>$'.number_format($cart->precio, 2).'</td>'.
                              '   <td><a href="#" class="" onclick="eliminar('.$cart->id_cuenta.')"><i class="fa fa-trash"></i></a></td>'.
                              '</tr>';
                    $total = ($total + $cart->precio);
                }
                $result.= '<tr>'.
                          '   <td colspan="4">Neto $</td>'.
                          '   <td>$'.number_format($total, 2 ).'</td>'.
                          '   <td></td>'.
                          '</tr>';
                return Response($result);
            }
        }
    }
    public function ticket()
    {
        //header('Content-Type: application/pdf;');
        //header('Content-Disposition: attachment; filename="ticketpdf.pdf"');
        $venta = Venta::all()->last();
        $user = \Auth::user();
        $date = Carbon::now();
        $total = 0;
        if ($venta->id_venta) {
            $cobro = Cobro::all()->where('id_venta', $venta->id_venta);
            $ventas = DB::table('cuenta')
                ->join('venta', 'cuenta.id_venta', '=', 'venta.id_venta')
                ->join('cobro', 'cuenta.id_venta', '=', 'cobro.id_venta')
                ->join('detallealmacen', 'cuenta.id_detallea', '=', 'detallealmacen.id_detallea')
                ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                ->select('venta.id_venta', 'sucursales.nombre_sucursal', 'cuenta.id_detallea', 'cuenta.cantidad', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'cuenta.precio', 'cobro.monto_total')
                ->where('cuenta.id_venta', $venta->id_venta)
                ->get();
            $total = count($ventas);
            $pdf = PDF::loadView('venta.ticketpdf', compact('ventas', 'date', 'cobro', 'total', 'user'));
            return $pdf->download('ticketpdf.pdf');
            //return view('venta.ticket', compact('ventas', 'date', 'cobro', 'total', 'user'));
        }
    }
}
