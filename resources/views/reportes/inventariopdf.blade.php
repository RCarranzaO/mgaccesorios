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
            <div align="right">Fecha:</div>
            <table align="center" width="100%" border="1" cellspacing="0" cellpadding="2">
                <tr>
                    <td colspan="8" bgcolor="skyblue"><center><strong>REPORTE DE INVENTARIO</strong></center></td>
                </tr>
                <tr bgcolor="gray"  align="center">
                    <td><strong>REFERENCIA</strong></td>
                    <td><strong>CATEGORIA</strong></td>
                    <td><strong>TIPO</strong></td>
                    <td><strong>MARCA</strong></td>
                    <td><strong>MODELO</strong></td>
                    <td><strong>SUCURSAL</strong></td>
                    <td><strong>EXISTENCIA</strong></td>
                </tr>
                @if ($productos->count())
                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto->referencia }}</td>
                            <td>{{ $producto->categoria_producto }}</td>
                            <td>{{ $producto->tipo_producto }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td>{{ $producto->modelo }}</td>
                            <td>{{ $producto->nombre_sucursal }}</td>
                            <td>{{ $producto->existencia }}</td>
                        </tr>
                      @endforeach
                    @else
                      <tr>
                          <td colspan="8"><h3>No hay registros!!</h3></td>
                      </tr>
                    @endif
            </table>
        </div>
    </body>
</html>
