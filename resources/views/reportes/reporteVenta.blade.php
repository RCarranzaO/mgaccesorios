@php
    $total = 0;
@endphp
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title></title>
        <!--Script-->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/jquery/jquery-3.3.1.min.js" charset="utf-8"></script>
        <!--Style-->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    </head>
    <body>
        <br>
        <div class="container">
            <table class="table text-center table-responsive-sm" align="center" width="100%" cellspacing="0" cellpadding="2">
                <thead>
                    <tr>
                      <td colspan="11"><center><strong>Reporte de Venta generado: {{ $fecha }}</strong></center></td>
                    </tr>
                </thead>
                <tbody>
                  <tr style="font-size: 15px">
                      <td class="text-center"><strong># Folio</strong></td>
                      <td colspan="4"><strong>Fecha</strong></td>
                      <td colspan="2" class="text-left"><strong>Empleado</strong></td>
                      <td><strong>Sucursal</strong></td>
                      <td class="text-right"><strong>Estado</strong></td>
                      <td colspan="2" class="text-right"><strong>Total</strong></td>
                  </tr>
                  @if ($ventas->count())
                      @foreach ($ventas as $venta)
                          @if($venta->estatus != 0)
                              <tr style="font-size: 12px">
                                  <td class="text-center">{{ $venta->id_venta }}</td>
                                  <td colspan="4" class="text-left">{{ $fecha }}</td>
                                  <td colspan="2" class="text-left">{{ $venta->username }}</td>
                                  <td class="text-center">{{ $venta->nombre_sucursal }}</td>
                                  <td class="text-right"> {{ $estado = ($venta->estatus ==1) ? 'Finalizada' : 'Cancelada' }}</td>
                                  <td colspan="2" class="text-right">$ {{ number_format($venta->monto_total, 2) }}</td>
                              </tr>
                              @php
                                  $total = $total+($venta->monto_total);
                              @endphp
                          @endif
                      @endforeach
                        <tr style="font-size: 13px">
                            <td></td>
                            <td colspan="4"></td>
                            <td colspan="2"></td>
                            <td class="text-left"><strong>Total de ventas: {{ $ventas->count() }}</strong></td>
                            <td colspan="4" class="text-right"><strong>Total: $ {{ number_format($total, 2) }}</strong></td>
                        </tr>
                  @else
                    <tr>
                      <td colspan="8"><h3>{{ 'No se encuentran registros en la base de datos.' }}</h3></td>
                    </tr>
                  @endif
                </tbody>
            </table>
        </div>
    </body>
</html>
