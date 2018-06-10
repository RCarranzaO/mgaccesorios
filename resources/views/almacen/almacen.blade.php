@extends('layouts.app')
@section('content')
    @if (Auth::user()->rol == 1)

        <div class="container">
            <nav class="navbar navbar-ligth bg-ligth justify-content-left ">
                <form class="form-inline" action="" method="post">
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
        </div>
    @else
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                $("#myModal").modal("show");
            });
        </script>
        <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"  id="exampleModalLabel">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h3>No tienes lo privilegios para entrar aquí!! Adios!</h3>
                    </div>
                    <div class="modal-footer">
                        <form class="" action="{{ route('home') }}">
                            <button type="submit" class="btn btn-outline-primary">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
