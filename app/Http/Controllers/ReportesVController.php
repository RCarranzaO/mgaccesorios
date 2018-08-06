<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Cobro;
use mgaccesorios\Venta;
use mgaccesorios\Sucursal;
use Carbon\Carbon;

class ReportesVController extends Controller
{

    /**
     * La función function_construct se encarga de verificar que el usuario ha iniciado sesión antes de poder realizar cualquier acción.
     * @return
     */
    public function __construct()
    {
       $this->middleware('auth');
    }
    public function index()
    {
        $date = Carbon::now()->toDateString();
        $usuario = \Auth::user();
        if ($usuario->rol == "1") {
            $ventas = DB::table('cobro')
                ->join('venta', 'cobro.id_venta', '=', 'venta.id_venta')
                ->join('users', 'cobro.id_user', '=', 'users.id_user')
                ->join('sucursales', 'cobro.id_sucursal', '=', 'sucursales.id_sucursal')
                ->select('venta.id_venta', 'cobro.fecha', 'users.username', 'sucursales.nombre_sucursal', 'venta.estatus', 'cobro.monto_total')
                ->paginate(10);
        } else {
            $ventas = DB::table('cobro')
                ->join('venta', 'cobro.id_venta', '=', 'venta.id_venta')
                ->join('users', 'cobro.id_user', '=', 'users.id_user')
                ->join('sucursales', 'cobro.id_sucursal', '=', 'sucursales.id_sucursal')
                ->select('venta.id_venta', 'cobro.fecha', 'users.username', 'sucursales.nombre_sucursal', 'venta.estatus', 'cobro.monto_total')
                ->where('sucursales.id_sucursal', $usuario->id_sucursal)
                ->paginate(10);
        }

        return view('reportes.ventas', compact('ventas', 'date'));
    }

    public function buscar(Request $request)
    {
        $user = \Auth::user();
        $fecha = Carbon::now()->toDateString();
        if ($request->ajax()) {
            $result = "";
            if ($request->fecha_i != '' && $request->fecha_f != '') {
                if ($request->fecha_f >= $request->fecha_i && $request->fecha_f <= $fecha) {
                    if ($user->rol == '1') {
                      $ventas = DB::table('cobro')
                      ->join('venta', 'cobro.id_venta', '=', 'venta.id_venta')
                      ->join('users', 'cobro.id_user', '=', 'users.id_user')
                      ->join('sucursales', 'cobro.id_sucursal', '=', 'sucursales.id_sucursal')
                      ->select('venta.id_venta', 'cobro.fecha', 'users.username', 'sucursales.nombre_sucursal', 'venta.estatus', 'cobro.monto_total')
                      ->whereBetween('cobro.fecha', [$request->fecha_i, $request->fecha_f])
                      ->get();
                      foreach ($ventas as $venta) {
                        $result .= '<tr>'.
                        '<td>'.$venta->id_venta.'</td>'.
                        '<td>'.$venta->fecha.'</td>'.
                        '<td>'.$venta->username.'</td>'.
                        '<td>'.$venta->nombre_sucursal.'</td>'.
                        '<td>'.$estado = ($venta->estatus == 1) ? "Finalizada" : "Cancelada".'</td>'.
                        '<td>'.$venta->monto_total.'</td>'.
                        '<td><button type="button" onclick="imprimir('.$venta->id_venta.')" class="btn btn-warning-outline"><i class="fa fa-print"></i></button></td>'.
                        '</tr>';
                      }
                      return Response($result);
                    } else {
                      $ventas = DB::table('cobro')
                      ->join('venta', 'cobro.id_venta', '=', 'venta.id_venta')
                      ->join('users', 'cobro.id_user', '=', 'users.id_user')
                      ->join('sucursales', 'cobro.id_sucursal', '=', 'sucursales.id_sucursal')
                      ->select('venta.id_venta', 'cobro.fecha', 'users.username', 'sucursales.nombre_sucursal', 'venta.estatus', 'cobro.monto_total')
                      ->whereBetween('cobro.fecha', [$request->fecha_i, $request->fecha_f])
                      ->where('sucursales.id_sucursal', $user->id_sucursal)
                      ->get();
                      foreach ($ventas as $venta) {
                        $result .= '<tr>'.
                        '<td>'.$venta->id_venta.'</td>'.
                        '<td>'.$venta->fecha.'</td>'.
                        '<td>'.$venta->username.'</td>'.
                        '<td>'.$venta->nombre_sucursal.'</td>'.
                        '<td>'.$estado = ($venta->estatus == 1) ? "Finalizada" : "Cancelada" .'</td>'.
                        '<td>'.$venta->monto_total.'</td>'.
                        '<td><button type="button" onclick="imprimir('.$venta->id_venta.')" class="btn btn-warning-outline"><i class="fa fa-print"></i></button></td>'.
                        '</tr>';
                      }
                      return Response($result);
                    }
                } else {
                    $result .= '<tr><td colspan="6">
                                <div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    El rango no es valido
                                </td></tr></div>';
                }
            } else {
                $result .= '<tr><td colspan="6">
                            <div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                Seleccione rango de fechas!
                            </td></tr></div>';
                return Response($result);
            }

        }
    }

    public function ticket_pdf(Request $request)
    {
        $total = 0;
        $articulos = 0;
        $date = Carbon::now()->toDateString();
        $result = "";
        if ($request->ajax()) {
            $venta = Venta::find($request->id);
            if (!empty($venta)) {
              $cobro = Cobro::find($venta->id_venta);
              $ventas = DB::table('cuenta')
                    ->join('venta', 'cuenta.id_venta', '=', 'venta.id_venta')
                    ->join('cobro', 'cuenta.id_venta', '=', 'cobro.id_venta')
                    ->join('detallealmacen', 'cuenta.id_detallea', '=', 'detallealmacen.id_detallea')
                    ->join('users', 'cobro.id_user', '=', 'users.id_user')
                    ->join('producto', 'detallealmacen.id_producto', '=', 'producto.id_producto')
                    ->join('sucursales', 'detallealmacen.id_sucursal', '=', 'sucursales.id_sucursal')
                    ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                    ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                    ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                    ->select('venta.id_venta', 'users.id_user', 'users.username', 'sucursales.nombre_sucursal', 'cuenta.id_detallea', 'cuenta.cantidad', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'cuenta.precio', 'cobro.monto_total')
                    ->where('cuenta.id_venta', $venta->id_venta)
                    ->get();
              $result .='<h5 class="card-title" style="text-align: center; align-content: center;">
                            TICKET DE VENTA
                        </h5>
                        <p style="text-align: center; align-content: center;">
                        Mérida, Yucatán<br>
                        '.$date.'<br>';
              foreach ($ventas as $user) {
                  $result .= 'cajero: '.$user->username.'</p>';
              }
              $result .= 'N° venta: '.$request->id.'';
              $result .='<table style="border-top: 1px solid black; border-collapse: collapse;">
                            <thead>
                                <tr style="border-top: 1px solid black; border-collapse: collapse;">
                                    <th style="width: 100px; max-width: 100px; word-break: break-all;">Cantidad </th>
                                    <th style="width: 100px; max-width: 100px;">Descripcion </th>
                                    <th style="width: 100px; max-width: 100px; word-break: break-all;">Importe </th>
                                </tr>
                            </thead>
                            <tbody>';
              foreach ($ventas as $venta){
                  $result .= '<tr style="border-top: 1px solid black; border-collapse: collapse;">
                                  <td style="border-top: 1px solid black; border-collapse: collapse;
                                  width: 100px; max-width: 100px; word-break: break-all;">'.$venta->cantidad.'</td>
                                  <td style="border-top: 1px solid black; border-collapse: collapse;
                                  width: 100px; max-width: 100px;">'.$venta->nombrec.' '.$venta->nombret.' '.$venta->nombrem.'</td>
                                  <td style="border-top: 1px solid black; border-collapse: collapse;
                                  width: 100px; max-width: 100px; word-break: break-all;">'.$venta->precio.'</td>
                              </tr>';
              }
              foreach ($ventas as $vent) {
                  $articulos = $articulos+$vent->cantidad;
              }
              $result .= '<tr style="border-top: 1px solid black; border-collapse: collapse;">
                              <td colspan="2" style="border-top: 1px solid black; border-collapse: collapse;
                              width: 100px; max-width: 100px;">No. de articulos</td>
                              <td style="border-top: 1px solid black; border-collapse: collapse;
                              width: 100px; max-width: 100px; word-break: break-all;">'.$articulos.'</td>
                          </tr>
                          <tr>
                              <td colspan="2" style="width: 100px; max-width: 100px;">Total</td>
                              <td style="width: 100px; max-width: 100px; word-break: break-all;">'.$venta->monto_total.'</td>
                          </tr>
                          </tbody>
                          </table>
                          <p style="text-align: center; align-content: center;">¡GRACIAS POR SU COMPRA!<br>MgAccesorios</p>';
            } else {
              // code...
            }
            return Response($result);

        }
    }

    public function venta_pdf($id)
    {
        $venta = Venta::find($id);
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
                ->join('categorias', 'producto.id_categoria', '=', 'categorias.id_categoria')
                ->join('tipos', 'producto.id_tipo', '=', 'tipos.id_tipo')
                ->join('marcas', 'producto.id_marca', '=', 'marcas.id_marca')
                ->select('venta.id_venta', 'sucursales.nombre_sucursal', 'cuenta.id_detallea', 'cuenta.cantidad', 'categorias.nombrec', 'tipos.nombret', 'marcas.nombrem', 'producto.modelo', 'cuenta.precio', 'cobro.monto_total')
                ->where('cuenta.id_venta', $venta->id_venta)
                ->get();
            $total = count($ventas);
            $pdf = PDF::loadView('venta.ticketpdf', compact('ventas', 'date', 'cobro', 'total', 'user'));
            return $pdf->download('ticketpdf.pdf');
      }
  }
}
