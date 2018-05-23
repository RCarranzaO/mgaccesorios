@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table text-center table-responsive-sm">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Refencia</th>
                <th scope="col">Categoria</th>
                <th scope="col">Tipo</th>
                <th scope="col">Marca</th>
                <th scope="col">Modelo</th>
                <th scope="col">Color</th>
                <th scope="col">Precio Compra</th>
                <th scope="col">Precio Venta</th>
                <th scope="col"></th>
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
                        <td>{{ $producto->precio_compra}}</td>
                        <td>{{ $producto->precio_venta }}</td>
                        <td>
            							<a href="{{ route('producto.edit', $producto->id_producto) }}" class="btn btn-outline-info">Editar</a>
            						</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8">No hay registros!!</td>
                </tr>
            @endif

        </tbody>
    </table>

</div>
@endsection
