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
                        <th scope="col">Referencia</th>
                        <th scope="col">Producto</th>
                        <th scope="col" class="text-left">Sucursal</th>
                        <th scope="col">Existencia</th>
                        <th scope="col" class="text-right">Precio</th>
                        <th scope="col" class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($productos->count())
                        @foreach ($productos as $producto)
                            <tr>
                              <td>{{ $producto->referencia }}</td>
                              <td class="text-left">{{ $producto->categoria_producto }} {{ $producto->tipo_producto }} {{ $producto->marca }} {{ $producto->modelo }} {{ $producto->color }}</td>
                              <td class="text-left">{{ $producto->nombre_sucursal }}</td>
                              <td>{{ $producto->existencia }}</td>
                              <td class="text-right">$ {{ number_format($producto->precio_venta, 2) }}</td>
                              <td class="text-right">$ {{ number_format($producto->precio_venta*$producto->existencia, 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8"><h3>No hay registros!!</h3></td>
                        </tr>
                    @endif

                </tbody>
            </table>
            {{ $productos->links() }}
        </div>

@endsection
