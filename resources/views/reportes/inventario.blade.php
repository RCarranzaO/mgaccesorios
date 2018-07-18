@extends('layouts.app')
@section('content')
    <script src="{{ asset('js/jquery/jquery-3.3.1.min.js') }}"></script>
        <div class="container">
            @include('alerts.success')
            <nav class="navbar navbar-ligth bg-ligth justify-content-left ">
                <form class="form-inline" action="#" method="get">
                    <input type="text" id="buscar" class="form-control mr-sm-2" name="buscar" placeholder="Buscar por referencia" onkeyup="">
                    <input type="text" id="buscarN" class="form-control mr-sm-2" name="buscarN" placeholder="Buscar por nombre">
                    @if (Auth::user()->rol == 1)
                        <a href="{{ route('almacen.pdf') }}" class="btn btn-outline-primary">Descargar productos en PDF</a>
                    @endif
                </form>
            </nav>

            <div class="card">
                <div class="card-header background-light">
                    <h4 class="card-title">Listado de productos</h4>
                </div>
                <div class="card-body">
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
                    <hr>
                    {{ $productos->links() }}
                </div>
            </div>
        </div>

@endsection
@section('script')
    <script>
        $('#buscar').on('keyup', function(){
            $value=$(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route('buscarA') }}',
                data: {'buscar':$value},
                success:function(data){
                    $('tbody').html(data);
                }
            });
        });

    </script>
    <script type="text/javascript">
        $.ajaxSetup({headers: {'csrftoken' : '{{ csrf_token() }}'} });
    </script>
@endsection
