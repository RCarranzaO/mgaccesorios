@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Generar venta</h1>
        <div class="card">
            <div class="card-header background-light">
                <h3 class="card-title">Nueva Venta</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <form class="form" action="" method="post">
                          @csrf
                            <div class="card card-info">
                                <div class="card-header background-light">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 class="card-title">Detalles de la Venta</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-outline-success pull-right" name="button"><i class="fa fa-print">Imprimir ticket</i></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-background">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                  <label for="sucursal">Sucursal</label>
                                                  @foreach ($sucursales as $sucursal)
                                                      @if ($sucursal->id_sucursal == $user->id_sucursal)
                                                          <input type="text" class="form-control" value="{{ $sucursal->nombre_sucursal }}" disabled>
                                                      @endif
                                                  @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="fecha">Fecha</label>
                                                  <input type="date" class="form-control" value="{{ $fecha = date('Y-m-d') }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group text-center">
                                                  <label for="venta">Venta N°</label>
                                                  <input type="text" class="form-control text-right" value="{{ empty($venta) ? 1 : $venta->id_venta+1 }}" disabled >
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                  <label for="buscar">Agregar productos</label>
                                                  <button type="button" class="btn btn-block btn-outline-info" name="button" data-toggle="modal" data-target="#ModalProd">Buscar Producto</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <table class="table text-center table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th scope="col"><strong>Referencia</strong></th>
                                        <th scope="col"><strong>Cantidad</strong></th>
                                        <th scope="col"><strong>Descripción</strong></th>
                                        <th scope="col" class="text-right"><strong>Precio unit.</strong></th>
                                        <th scope="col" class="text-right"><strong>Precio total</strong></th>
                                        <th scope="col"></th>
                                    </tr>
                                    {{ csrf_field() }}
                                </thead>
                                <tbody id="carrito">

                                </tbody>
                            </table>
                        </div>
                        <div id="ModalProd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input type="text" id="search" class="form-control" name="search" placeholder="Buscar productos" onkeyup="">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <button type="button" class="btn btn-outline-dark">Buscar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <table class="table text-center table-responsive-sm">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Referencia</th>
                                                    <th scope="col">Producto</th>
                                                    <th scope="col" class="text-left">Sucursal</th>
                                                    <th scope="col">Existencia</th>
                                                    <th scope="col" class="text-right">Precio</th>
                                                    <th scope="col">Cantidad</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="formproduc">
                                                @if ($productos->count())
                                                    @foreach ($productos as $producto)
                                                        @if ($producto->estatus != 0)
                                                            <tr>
                                                              <td>{{ $producto->referencia }}</td>
                                                              <td class="text-left">{{ $producto->categoria_producto }} {{ $producto->tipo_producto }} {{ $producto->marca }} {{ $producto->modelo }} {{ $producto->color }}</td>
                                                              <td class="text-left">{{ $producto->nombre_sucursal }}</td>
                                                              <td>{{ $producto->existencia }}</td>
                                                              <td class="text-right">${{ number_format($producto->precio_venta, 2) }}</td>
                                                              <td><input type="number" id="cantidad" name="cantidad" class="text-center" style="width:50px"></td>
                                                              <td><button type="button" class="btn btn-outline-primary" onclick="agregar({{ $producto->id_detallea }})">Agregar</button></td>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#search').on('keyup', function(){
            $value=$(this).val();

            $.ajax({

                type: 'get',
                url: '{{ route('buscarV') }}',
                data: {'search':$value},
                success:function(data){
                    $('#formproduc').html(data);
                }
            });
        })
    </script>
    <script>
        function agregar(id) {
            var cantidad = $('#cantidad').val();
            var _token = $('input[name=_token]').val();
            console.log(id);
            if(cantidad != ''){
                $.ajax({
                    url: '{{ route('venta.store') }}',
                    type: 'get',
                    data: {'cantidad':cantidad, 'id':id, '_token':_token},
                    success:function(data){
                        $('#carrito').html(data);

                    }
                });
            }
        }
    </script>
    <script type="text/javascript">
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
    </script>
@endsection
