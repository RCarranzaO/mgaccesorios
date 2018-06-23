@extends('layouts.app')
@section('content')
    @if (Auth::user()->rol == 1)
        <div class="container">
            <p>
                <!--<a href="{{ route('almacen.pdf') }}" class="btn btn-sm btn-primary">
                Descargar productos en PDF
              </a>-->
            </p>
            <table class="table text-center table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad Vendida</th>
                        <th scope="col">Monto venta por poducto</th>
                        <th scope="col">Sucursal</th>
                        <th scope="col">Monto Total de las Ventas</th>
                    </tr>
                </thead>
                <!--<tbody>
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

                </tbody>-->
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
