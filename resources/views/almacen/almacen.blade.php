@extends('layouts.app')
@section('content')
    @if (Auth::user()->rol == 1)
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
                        <th scope="col">Precio</th>
                        <th scope="col">Sucursal</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($productos->count())
                        @foreach ($productos as $producto)
                            <tr>
                                <td>{{ 1 }}</td>
                                <td>{{ 2 }}</td>
                                <td>{{ 3 }}</td>
                                <td>{{ 4 }}</td>
                                <td>{{ 5 }}</td>
                                <td>{{ 6 }}</td>
                                <td>{{ 7 }}</td>
                                <td>{{ 8 }}</td>
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
