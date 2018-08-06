<?php

namespace mgaccesorios\Http\Controllers;

use Illuminate\Http\Request;
use mgaccesorios\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use mgaccesorios\Cobro;
use mgaccesorios\Venta;
use mgaccesorios\Sucursal;

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
        $usuario = \Auth::user();
        if ($usuario->rol == "1") {
            $ventas = DB::table('cobro')
                ->join('venta', 'cobro.id_venta', '=', 'venta.id_venta')
                ->join('users', 'cobro.id_user', '=', 'users.id_user')
                ->join('sucursales', 'cobro.id_sucursal', '=', 'sucursales.id_sucursal')
                ->select('venta.id_venta', 'cobro.fecha', 'users.username', 'sucursales.nombre_sucursal', 'venta.estatus', 'cobro.monto_total')
                ->get();
        } else {
            $ventas = DB::table('cobro')
                ->join('venta', 'cobro.id_venta', '=', 'venta.id_venta')
                ->join('users', 'cobro.id_user', '=', 'users.id_user')
                ->join('sucursales', 'cobro.id_sucursal', '=', 'sucursales.id_sucursal')
                ->select('venta.id_venta', 'cobro.fecha', 'users.username', 'sucursales.nombre_sucursal', 'venta.estatus', 'cobro.monto_total')
                ->where('sucursales.id_sucursal', $usuario->id_sucursal)
                ->get();
        }

        return view('reportes.ventas', compact('ventas'));
    }

    public function buscar(Request $request)
    {
        $ventas = DB::table('cobro')
            ->join('venta', 'cobro.id_venta', '=', 'venta.id_venta')
            ->join('users', 'cobro.id_user', '=', 'users.id_user')
            ->join('sucursales', 'cobro.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('venta.id_venta', 'cobro.fecha', 'users.username', 'sucursales.nombre_sucursal', 'venta.estatus', 'cobro.monto_total')
            ->get();
        $user = \Auth::user();
        if ($request->ajax()) {
            $result = "";
            if ($request->fecha_i != '' && $request->fecha_f != '') {
                if ($user->rol == '1') {
                    $ventas = $ventas->whereBetween($request->fecha_i, $request->fecha_f)->get();
                    foreach ($ventas as $venta) {
                        $result .= '<tr>'.
                                      '<td>'.$venta->id_venta.'</td>'.
                                      '<td>'.$venta->fecha.'</td>'.
                                      '<td>'.$venta->username.'</td>'.
                                      '<td>'.$venta->nombre_sucursal.'</td>'.
                                      '<td>'.$venta->estatus.'</td>'.
                                      '<td>'.$venta->monto_total.'</td>'.
                                   '</tr>';
                    }
                    return Response($result);
                } else {
                    $ventas = $ventas->whereBetween($request->fecha_i, $request_f)->where('sucursales.id_sucursal', $user->id_sucursal)->get();
                    foreach ($ventas as $venta) {
                        $result .= '<tr>'.
                                      '<td>'.$venta->id_venta.'</td>'.
                                      '<td>'.$venta->fecha.'</td>'.
                                      '<td>'.$venta->username.'</td>'.
                                      '<td>'.$venta->nombre_sucursal.'</td>'.
                                      '<td>'.$venta->estatus.'</td>'.
                                      '<td>'.$venta->monto_total.'</td>'.
                                   '</tr>';
                    }
                    return Response($result);
                }

            } else {
                $result .= '<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                Seleccione rango de fechas!
                            </div>';
                return Response($result);
            }

        }
    }

    public function pdf()
    {

        $ventas = DB::table('cobro')
            ->join('venta', 'cobro.id_venta', '=', 'venta.id_venta')
            ->join('users', 'cobro.id_user', '=', 'users.id_user')
            ->join('sucursales', 'cobro.id_sucursal', '=', 'sucursales.id_sucursal')
            ->select('venta.id_venta', 'cobro.fecha', 'users.username', 'sucursales.nombre_sucursal', 'venta.estatus', 'cobro.monto_total')
            ->get();
        $fecha = date('Y-m-d');

        $pdf = PDF::loadView('reportes.ventaspdf', compact('ventas', 'fecha'));

        return $pdf->download('Reporte de ventas'.$fecha.'.pdf');
    }
}
