<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title>Mg Accesorios</title>
      <style>

          td.producto, th.producto {
              width: 75px;
              max-width: 75px;
          }

          td.cantidad, th.cantidad {
              width: 40px;
              max-width: 40px;
              word-break: break-all;
          }

          td.precio, th.precio {
              width: 40px;
              max-width: 40px;
              word-break: break-all;
          }
      </style>
    </head>
    <body>
        <div class="card" style="width: 155px; max-width: 155px;">
            <div class="card-body">
                <h5 class="card-title" style="text-align: center; align-content: center;">
                    TICKET DE VENTA
                </h5>
                <p style="text-align: center; align-content: center;">
                  Mérida, Yucatán<br>
                  {{ $date }}<br>
                  cajero: {{ $user->username }}
                </p>
                @foreach ($cobro as $cobrar)
                    N° venta: {{ $cobrar->id_venta }}
                @endforeach
                <table style="border-top: 1px solid black;
                border-collapse: collapse;">
                    <thead>
                        <tr style="border-top: 1px solid black;
                        border-collapse: collapse;">
                            <th class="cantidad">Cantidad </th>
                            <th class="producto">Descripcion </th>
                            <th class="precio">Importe </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr style="border-top: 1px solid black;
                            border-collapse: collapse;">
                                <td class="cantidad" style="border-top: 1px solid black;
                                border-collapse: collapse;">{{ $venta->cantidad }}</td>
                                <td class="producto" style="border-top: 1px solid black;
                                border-collapse: collapse;">{{ $venta->categoria_producto }} {{ $venta->tipo_producto }} {{ $venta->marca }}</td>
                                <td class="precio" style="border-top: 1px solid black;
                                border-collapse: collapse;">{{ $venta->precio }}</td>
                            </tr>
                        @endforeach
                        <tr style="border-top: 1px solid black;
                        border-collapse: collapse;">
                            <td colspan="2" class="producto" style="border-top: 1px solid black;
                            border-collapse: collapse;">No. de articulos</td>
                            <td class="precio" style="border-top: 1px solid black;
                            border-collapse: collapse;">{{ $total }}</td>
                        </tr>
                        <tr>
                            <td class="cantidad"></td>
                            <td class="producto">Total</td>
                            <td class="precio">{{ $venta->monto_total }}</td>
                        </tr>
                    </tbody>
                </table>
                <p style="text-align: center; align-content: center;">GRACIAS POR SU COMPRA!!<br>MgAccesorios</p>
            </div>
        </div>
    </body>
</html>
