@extends('layouts.app')
@section('content')

        <div class="container">
            @if (Auth::user()->rol == 1)
            <p>
                <a href="{{ route('almacen.pdf') }}" class="btn btn-sm btn-primary">
                Descargar productos en PDF
                </a>
            </p>
            @endif
            <table class="table text-center table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Refencia</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Color</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Sucursal</th>
                        <th scope="col">existencia</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($productos->count())
                        @foreach ($productos as $producto)
                            <tr>
                              <td>{{ $producto->referencia }}</td>
                              <td>{{ $producto->categoria_producto }}</td>
                              <td>{{ $producto->tipo_producto }}</td>
                              <td>{{ $producto->marca }}</td>
                              <td>{{ $producto->modelo }}</td>
                              <td>{{ $producto->color }}</td>
                              <td>{{ $producto->precio_venta }}</td>
                              <td>{{ $producto->nombre_sucursal }}</td>
                              <td>{{ $producto->existencia }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8"><h3>No hay registros!!</h3></td>
                        </tr>
                    @endif

                </tbody>
            </table>
            <hr>
        </div>

@endsection
