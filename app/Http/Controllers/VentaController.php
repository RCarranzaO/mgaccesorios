<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use mgaccesorios\Venta;
use mgaccesorios\Sucursal;
use mgaccesorios\Cuenta;
use mgaccesorios\Cobro;
use mgaccesorios\Fondo;
use mgaccesorios\DetalleAlmacen;
use Carbon\Carbon;

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
        $fondo = Fondo::all()->last();
        $sucursales = Sucursal::all();
        $fecha = date('Y-m-d');
        $user = \Auth::user();
        $productos = DB::table('detallealmacen')
            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
            ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('detallealmacen.id_detallea', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'producto.precio_venta', 'sucursales.nombre_sucursal', 'detallealmacen.existencia', 'producto.estatus')
            ->orderBy('detallealmacen.id_detallea')
            ->where('detallealmacen.id_sucursal', $user->id_sucursal)
            ->get();
        if (empty($fondo->fecha)) {
            return view('fondo.fondo', compact('fondo', 'user'));
        } elseif($fondo->fecha != $fecha) {
            return view('fondo.fondo', compact('fondo', 'user'))->with('fail', 'No se puede realizar una venta, aún no se ha ingresado un fondo');
        } else {
            return view('venta.venta', compact('sucursales', 'user', 'venta', 'productos'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = \Auth::user();
        $date = Carbon::now();
        $total = 0;
        if ($request->ajax()) {
            $cobro = Cobro::all()->where('id_venta', $request->id);
            $ventas = DB::table('cuenta')
                ->join('venta', 'cuenta.id_venta', '=', 'venta.id_venta')
                ->join('cobro', 'cuenta.id_venta', '=', 'cobro.id_venta')
                ->join('detallealmacen', 'cuenta.id_detallea', '=', 'detallealmacen.id_detallea')
                ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                ->select('venta.id_venta', 'sucursales.nombre_sucursal', 'cuenta.id_detallea', 'cuenta.cantidad', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'cuenta.precio', 'cobro.monto_total')
                ->where('cuenta.id_venta', $request->id)
                ->get();
            $total = count($ventas);
            $pdf = PDF::loadView('venta.ticket', compact('ventas', 'date', 'cobro', 'total', 'user'));

        }
        return $pdf->download('ticket.pdf');
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
            $date = Carbon::now();
            foreach ($cuentas as $cuenta) {
                $almacen = $almacenes->where('id_detallea', $cuenta->id_detallea);
                foreach ($almacen as $alma) {
                    $alma->existencia = $alma->existencia - $cuenta->cantidad;
                    $alma->save();
                }
                $total = $total + $cuenta->precio;
            }
            if (empty($cobro)) {
              $cobrar->id_venta = $venta->id_venta;
              $cobrar->id_user = $user->id_user;
              $cobrar->monto_total = $total;
              $cobrar->fecha = $date;
              $venta->estatus = 1;
              $cobrar->save();
              $venta->save();
              return redirect()->route('guardarCobro')->with('success', 'Venta realizada correctamente');
            }elseif ($cobro->id_venta != $venta->id_venta) {
                $cobrar->id_venta = $venta->id_venta;
                $cobrar->id_user = $user->id_user;
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
                        ->select('cuenta.id_cuenta', 'cuenta.id_venta', 'cuenta.id_detallea', 'detallealmacen.id_producto', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'cuenta.cantidad', 'cuenta.precio', 'producto.precio_venta', 'cuenta.fecha')
                        ->where('cuenta.id_venta', $request->venta)
                        ->get();
            foreach ($cuentas as $cart) {
                $result.= '<tr>'.
                          '   <td>'.$cart->referencia.'</td>'.
                          '   <td class="text-center">'.$cart->cantidad.'</td>'.
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
    public function destroy($id)
    {
        $cuenta = Cuenta::find($id);
        //dd($cuenta);
        $cuenta->delete();
        return Response($cuenta);
    }

    public function cart_temp(Request $request)
    {
        $user = \Auth::user();
        $cuenta = new Cuenta();
        $date = Carbon::now();
        $ventas = Venta::all()->last();
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
                        $venta = new Venta();
                        $venta->id_sucursal = $user->id_sucursal;
                        $venta->save();
                        $cuenta->id_venta = $ventas->id_venta;
                        $cuenta->id_detallea = $carrito->id_detallea;
                        $cuenta->cantidad = $request->cantidad;
                        $cuenta->precio = $carrito->precio_venta*$request->cantidad;
                        $cuenta->fecha = $date;
                        $cuenta->save();
                    } elseif($ventas->estatus == NULL){
                        $cuenta->id_venta = $ventas->id_venta;
                        $cuenta->id_detallea = $carrito->id_detallea;
                        $cuenta->cantidad = $request->cantidad;
                        $cuenta->precio = $carrito->precio_venta*$request->cantidad;
                        $cuenta->fecha = $date;
                        $cuenta->save();
                        //dd($cuenta);
                    } elseif ($ventas->estatus == 1) {
                        $venta = new Venta();
                        $venta->id_sucursal = $user->id_sucursal;
                        $venta->save();
                        $cuenta->id_venta = $ventas->id_venta;
                        $cuenta->id_detallea = $carrito->id_detallea;
                        $cuenta->cantidad = $request->cantidad;
                        $cuenta->precio = $carrito->precio_venta*$request->cantidad;
                        $cuenta->fecha = $date;
                        $cuenta->save();
                    } elseif ($ventas->estatus == 0) {
                        return redirect()->route('venta.index')->with('fail', 'La venta esta cancelada');
                    }
                } else {
                    $result .= '<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    Existencias insufcientes!
                                </div>';
                    return Response($result);
                }


                $cuentas = DB::table('cuenta')
                            ->join('detallealmacen', 'cuenta.id_detallea', '=', 'detallealmacen.id_detallea')
                            ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                            ->select('cuenta.id_cuenta', 'cuenta.id_venta', 'cuenta.id_detallea', 'detallealmacen.id_producto', 'producto.referencia', 'producto.categoria_producto', 'producto.tipo_producto', 'producto.marca', 'producto.modelo', 'producto.color', 'cuenta.cantidad', 'cuenta.precio', 'producto.precio_venta', 'cuenta.fecha')
                            ->where('cuenta.id_venta', $ventas->id_venta)
                            ->get();
                foreach ($cuentas as $cart) {
                    $result.= '<tr>'.
                              '   <td>'.$cart->referencia.'</td>'.
                              '   <td class="text-center">'.$cart->cantidad.'</td>'.
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
                return Response($result);
            }
        }
    }
}
