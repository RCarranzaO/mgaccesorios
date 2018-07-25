@php
  $total=0;
  $existencia=0;
@endphp
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title></title>
        <!--Script-->
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/jquery/jquery-3.3.1.min.js" charset="utf-8"></script>
        <!--Style-->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    </head>
    <body>
        <br>
        <div class="container">
            <table class="table text-center table-responsive-sm" align="center" width="100%" cellspacing="0" cellpadding="2">
                <thead>
                    <tr>
                      <td colspan="11"><center><strong>Reporte de inventario generado: {{ $fecha }}</strong></center></td>
                    </tr>
                </thead>
                <tbody>
                  <tr style="font-size: 15px">
                      <td class="text-center"><strong>Referencia</strong></td>
                      <td colspan="4"><strong>Producto</strong></td>
                      <td colspan="2" class="text-left"><strong>Sucursal</strong></td>
                      <td><strong>Existencia</strong></td>
                      <td class="text-right"><strong>Precio</strong></td>
                      <td colspan="2" class="text-right"><strong>Total</strong></td>
                  </tr>
                  @if ($productos->count())
                      @foreach ($productos as $producto)
                          @if($producto->estatus != 0)
                              <tr style="font-size: 12px">
                                  <td class="text-center">{{ $producto->referencia }}</td>
                                  <td colspan="4" class="text-left">{{ $producto->categoria_producto }} {{ $producto->tipo_producto }} {{ $producto->marca }} {{ $producto->modelo }}</td>
                                  <td colspan="2" class="text-left">{{ $producto->nombre_sucursal }}</td>
                                  <td class="text-center">{{ $producto->existencia }}</td>
                                  <td class="text-right">$ {{ number_format($producto->precio_venta, 2) }}</td>
                                  <td colspan="2" class="text-right">$ {{ number_format($producto->precio_venta*$producto->existencia, 2) }}</td>
                              </tr>
                              @php
                                  $existencia = $existencia+$producto->existencia;
                                  $total = $total+($producto->precio_venta*$producto->existencia);
                              @endphp
                          @endif
                      @endforeach
                        <tr style="font-size: 13px">
                            <td></td>
                            <td colspan="4"></td>
                            <td colspan="2"></td>
                            <td class="text-left"><strong>Total: {{ $existencia }}</strong></td>
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
