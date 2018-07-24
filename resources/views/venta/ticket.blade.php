<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Mg Accesorios</title>
  </head>
  <body>
      {{ $date }}
      cajero: {{ $user->username }}
      @foreach ($cobro as $cobrar)
          N° venta: {{ $cobrar->id_venta }}
      @endforeach
      <table>
        <thead>
          <tr>
            <td>cantidad</td>
            <td>descripcion</td>
            <td>importe</td>
          </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                <tr>
                  <td>{{ $venta->cantidad }}</td>
                  <td>{{ $venta->categoria_producto }} {{ $venta->tipo_producto }} {{ $venta->marca }}</td>
                  <td>{{ $venta->precio }}</td>
                  <td>No. de articulos {{ $total }}</td>
                  <td>Total {{ $venta->monto_total }}</td>
                </tr>
            @endforeach
        </tbody>
      </table>

  </body>
</html>
