@extends('layouts.app')
@section('content')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <div class="container">
            <nav class="navbar navbar-ligth bg-ligth justify-content-left ">
                @include('alerts.success')
                <form class="form-inline" action="{{ route('buscaralm') }}" method="post">
                    @csrf
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" name="data" aria-label="Search">

                    <select class="form-control mr-sm-2" name="sucursal">
                        <option value="0">Todas las sucursales</option>
                        @foreach ($sucursales as $sucursal)
                            <option value="{{ $sucursal->id_sucursal }}">{{ $sucursal->nombre_sucursal }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </nav>
            <table class="table text-center table-responsive-sm" id="general">
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
            {{ $productos->links() }}
        </div>
@endsection
