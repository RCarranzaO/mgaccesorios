<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Mg Accesorios</title>
        <!--Script-->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/jquery/jquery-3.3.1.min.js" charset="utf-8"></script>
        <!--Style-->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    </head>
    <body>
        <div class="modal-body text-center" style="align-content: center">
            <div class="container-fluid">
                <div class="row">
                    
                    <div class="col-sm-6">
                        <div class="card" style="width: 300px; max-width: 300px; border: 1px solid black;">
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
                                <table style="border-top: 1px solid black;">
                                    <thead>
                                        <tr style="border-top: 1px solid black; border-collapse: collapse;">
                                            <th style="width: 100px; max-width: 100px; word-break: break-all;">Cantidad </th>
                                            <th style="width: 100px; max-width: 100px;">Descripcion </th>
                                            <th style="width: 100px; max-width: 100px; word-break: break-all;">Importe </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($ventas as $venta)
                                            <tr style="border-top: 1px solid black; border-collapse: collapse;">
                                                <td style="border-top: 1px solid black; border-collapse: collapse;
                                                width: 100px; max-width: 100px; word-break: break-all;">{{ $venta->cantidad }}</td>
                                                <td style="border-top: 1px solid black; border-collapse: collapse;
                                                width: 100px; max-width: 100px;">{{ $venta->categoria_producto }} {{ $venta->tipo_producto }} {{ $venta->marca }}</td>
                                                <td style="border-top: 1px solid black; border-collapse: collapse;
                                                width: 100px; max-width: 100px; word-break: break-all;">{{ $venta->precio }}</td>
                                            </tr>
                                        @endforeach
                                        <tr style="border-top: 1px solid black; border-collapse: collapse;">
                                            <td colspan="2" style="border-top: 1px solid black; border-collapse: collapse;
                                            width: 100px; max-width: 100px;">No. de articulos</td>
                                            <td style="border-top: 1px solid black; border-collapse: collapse;
                                            width: 100px; max-width: 100px; word-break: break-all;">{{ $total }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="width: 100px; max-width: 100px;">Total</td>
                                            <td style="width: 100px; max-width: 100px; word-break: break-all;">{{ $venta->monto_total }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p style="text-align: center; align-content: center;">¡GRACIAS POR SU COMPRA!<br>MgAccesorios</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
