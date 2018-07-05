@extends('layouts.app')
@section('content')
    <script src="{{ asset('js/jquery/jquery-3.3.1.min.js') }}"></script>
        <div class="container">
            <nav class="navbar navbar-ligth bg-ligth justify-content-left ">
                @include('alerts.success')
                <form class="form-inline" action="#" method="get">
                    <input type="text" id="buscar" class="form-control mr-sm-2" name="buscar" placeholder="Buscar producto" onkeyup="">

                    <!--<select class="form-control mr-sm-2" name="sucursal">
                        <option value="0">Todas las sucursales</option>
                        @foreach ($sucursales as $sucursal)
                            <option value="{{ $sucursal->id_sucursal }}">{{ $sucursal->nombre_sucursal }}</option>
                        @endforeach
                    </select>-->
                    <!--<button type="submit" class="btn btn-outline-success my-2 my-sm-0">Buscar</button>-->
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
                            @if ($producto->estatus != 0)
                                <tr>
                                    <td>{{ $producto->referencia }}</td>
                                    <td>{{ $producto->categoria_producto }}</td>
                                    <td>{{ $producto->tipo_producto }}</td>
                                    <td>{{ $producto->marca }}</td>
                                    <td>{{ $producto->modelo }}</td>
                                    <td>{{ $producto->color }}</td>
                                    <td>$ {{ number_format($producto->precio_venta,2) }}</td>
                                    <td>{{ $producto->nombre_sucursal }}</td>
                                    <td>{{ $producto->existencia }}</td>
                                </tr>
                            @endif
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
        })
    </script>
    <script type="text/javascript">
        $.ajaxSetup({headers: {'csrftoken' : '{{ csrf_token() }}'} });
    </script>
@endsection
