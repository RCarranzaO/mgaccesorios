@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header background-light">
                <h2 class="card-title">Nueva venta</h2>
            </div>
            @include('alerts.errores')
            @include('alerts.success')
            <div id="msgventa" class="col-sm-5"></div>
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
                                        <div class="col-md-3">
                                            <div class="text-right">
                                                <button type="button" class="btn btn-outline-secondary pull-right" onclick="store({{ empty($venta->id_venta) ? 1 : $venta->id_venta+1 }})" name="check"><i class="fa fa-check"></i>Realizar venta</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-right">
                                                @if (empty($venta->estatus))
                                                    <button type="button" class="btn btn-outline-success pull-right" name="button" disabled><i class="fa fa-print"></i> Imprimir ticket</button>
                                                @elseif ($venta->estatus == 1)
                                                    <button type="button" class="btn btn-outline-success pull-right" data-toggle="modal" data-target="#ModalImprimir"><i class="fa fa-print"></i> Imprimir ticket</button>
                                                @else
                                                    <button type="button" class="btn btn-outline-success pull-right" name="button" disabled><i class="fa fa-print"></i> Imprimir ticket</button>
                                                @endif
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
                                                  @if (empty($venta->id_venta) && empty($venta->estatus))
                                                      <input type="text" id="venta" class="form-control text-right" value="1" disabled >
                                                  @elseif ($venta->estatus == NULL)
                                                      <input type="text" id="venta" class="form-control text-right" value="{{ $venta->id_venta }}" disabled >
                                                  @else
                                                      <input type="text" id="venta" class="form-control text-right" value="{{ $venta->id_venta+1 }}" disabled >
                                                  @endif

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                  <label for="buscar">Agregar productos</label>
                                                  <button type="button" class="btn btn-block btn-outline-info" name="button" data-toggle="modal" data-target="#ModalProd"><i class="fa fa-search"></i> Buscar Producto</button>
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
                                    @csrf
                                </thead>
                                <tbody id="carrito">
                                    @if (empty($venta))

                                    @else
                                        @if ($venta->estatus == NULL)
                                            @foreach ($cuentas as $cuenta)
                                                <tr>
                                                    <td>{{ $cuenta->referencia }}</td>
                                                    <td class="text-center"><input type="number" min="1" max="{{ $cuenta->existencia }}" id="cantidad_{{ $cuenta->id_cuenta }}" class="text-center" style="width:50px" value="{{ $cuenta->cantidad }}"></td>
                                                    <td>{{ $cuenta->nombrec }}, {{ $cuenta->nombret }}, {{ $cuenta->nombrem }}, {{ $cuenta->modelo }}, {{ $cuenta->color }}</td>
                                                    <td>${{ number_format($cuenta->precio_venta, 2) }}</td>
                                                    <td>${{ number_format($cuenta->precio, 2) }}</td>
                                                    <td><a href="#" class="" onclick="eliminar({{ $cuenta->id_cuenta }})"><i class="fa fa-trash"></i></a></td>
                                                </tr>
                                            @endforeach
                                                <tr>
                                                    <td colspan="4">Neto $</td>
                                                    <td>{{ number_format($total, 2 ) }}</td>
                                                    <td></td>
                                                </tr>
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div id="ModalProd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    @include('alerts.errores')
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
                                                        <button type="button" class="btn btn-outline-dark"><i class="fa fa-search"></i> Buscar</button>
                                                    </div>
                                                    <div class="col-sm-5" id="msg">

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <table class="table text-center table-responsive-lg">
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
                                                @csrf
                                                @if ($productos->count())
                                                    @foreach ($productos as $producto)
                                                        @if ($producto->estatus != 0)
                                                            <tr>
                                                              <td>{{ $producto->referencia }}</td>
                                                              <td class="text-left">{{ $producto->nombrec }} {{ $producto->nombret }} {{ $producto->nombrem }} {{ $producto->modelo }} {{ $producto->color }}</td>
                                                              <td class="text-left">{{ $producto->nombre_sucursal }}</td>
                                                              <td>{{ $producto->existencia }}</td>
                                                              <td class="text-right">${{ number_format($producto->precio_venta, 2) }}</td>
                                                              <td><input type="number" min="1" max="{{ $producto->existencia }}" id="cantidad_{{ $producto->id_detallea }}" class="text-center" style="width:50px"></td>
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
                        <div id="ModalImprimir" class="modal fade" style="text-align: center; align-content: center;" tabindex="-1" role="dialog" aria-labelledby="myModalLabelImprimir" aria-hidden="true">
                            <div class="modal-dialog modal-lsm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabelImprimir">Ticket de venta</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center" style="align-content: center">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="card" style="width: 300px; max-width: 300px; border: 1px solid black;">
                                                        <div class="card-body">
                                                            @if (empty($venta))

                                                            @else
                                                                <h5 class="card-title" style="text-align: center; align-content: center;">
                                                                    TICKET DE VENTA
                                                                </h5>
                                                                <p style="text-align: center; align-content: center;">
                                                                  Mérida, Yucatán<br>
                                                                  {{ $date }}<br>
                                                                  cajero: {{ $user->username }}
                                                                </p>
                                                                @foreach ($cobro as $cobrar)
                                                                    N° venta: {{ $cobrar->id_venta }}
                                                                @endforeach
                                                                <table style="border-top: 1px solid black; border-collapse: collapse;">
                                                                    <thead>
                                                                        <tr style="border-top: 1px solid black; border-collapse: collapse;">
                                                                            <th style="width: 100px; max-width: 100px; word-break: break-all;">Cantidad </th>
                                                                            <th style="width: 100px; max-width: 100px;">Descripcion </th>
                                                                            <th style="width: 100px; max-width: 100px; word-break: break-all;">Importe </th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                        @foreach ($ventas as $venta)
                                                                            <tr style="border-top: 1px solid black; border-collapse: collapse;">
                                                                                <td style="border-top: 1px solid black; border-collapse: collapse;
                                                                                width: 100px; max-width: 100px; word-break: break-all;">{{ $venta->cantidad }}</td>
                                                                                <td style="border-top: 1px solid black; border-collapse: collapse;
                                                                                width: 100px; max-width: 100px;">{{ $venta->nombrec }} {{ $venta->nombret }} {{ $venta->nombrem }}</td>
                                                                                <td style="border-top: 1px solid black; border-collapse: collapse;
                                                                                width: 100px; max-width: 100px; word-break: break-all;">{{ $venta->precio }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                        <tr style="border-top: 1px solid black; border-collapse: collapse;">
                                                                            <td colspan="2" style="border-top: 1px solid black; border-collapse: collapse;
                                                                            width: 100px; max-width: 100px;">No. de articulos</td>
                                                                            <td style="border-top: 1px solid black; border-collapse: collapse;
                                                                            width: 100px; max-width: 100px; word-break: break-all;">{{ $articulos }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" style="width: 100px; max-width: 100px;">Total</td>
                                                                            <td style="width: 100px; max-width: 100px; word-break: break-all;">{{ $venta->monto_total }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <p style="text-align: center; align-content: center;">¡GRACIAS POR SU COMPRA!<br>MgAccesorios</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{ route('ticket') }}" class="btn btn-outline-success">Imprimir</a>
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
        function show() {
            console.log('show');
            var venta = $('#venta').val();
            $.ajax({
                url: '/venta/'+venta,
                type: 'get',
                data: {'venta':venta},
                success:function(data){
                    $('#carrito').html(data);
                }
            });
        }
    </script>
    <script>
        function store(id){
            var _token = $('input[name=_token]').val();
            console.log(id);
            $.ajax({
                url: '{{ route('venta.store') }}',
                type: 'post',
                data: {'id':id, '_token':_token},
                success:function(data){
                    location.href = "{{ route('venta.index') }}";
                    $('#msgventa').html('<div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Venta realizada con éxito.</div>');
                    //console.log('Venta realizada correctamente');
                }
            });
        }
    </script>
    <script>
        function agregar(id) {
          console.log('agregar');
            var cantidad = $('#cantidad_'+id).val();
            var _token = $('input[name=_token]').val();
            var max = $('#cantidad_'+id).attr("max");
            var min = $('#cantidad_'+id).attr("min");
            console.log(max);
            if(cantidad != ''){
                if (cantidad > max) {
                    $('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>La cantidad ingresada excede el número de existencias</div>');
                }else if(cantidad < min){
                    $('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>La cantidad ingresada es menor al mínimo requerido para vender.</div>');
                }else{

                  console.log(id);
                    $.ajax({
                        url: '/cart',
                        type: 'get',
                        data: {'cantidad':cantidad, 'id':id, '_token':_token},
                        success:function(data){
                            $('#carrito').html(data);
                            $('#msg').html('<div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Producto agregado.</div>');
                        }
                    });
                }
            }
        }
    </script>
    <script>
        function eliminar(id) {
          console.log('eliminar');
            var _token = $('input[name=_token]').val();
            var cantidad = $('#cantidad_'+id).val();
            console.log(id);
            $.ajax({
                url: '/venta/'+id,
                type: 'DELETE',
                data: {'id':id, 'cantidad':cantidad, '_token':_token},
                success:function(data){
                    $.ajax({
                        url: '/venta/'+1,
                        type: 'get',
                        data: {'_token':_token},
                        success:function(data){
                            show();
                        }
                    });
                }
            });
        }
    </script>
    <script>
        function imprimir(id) {
            //var _token = $('input[name=_token]').val();
            console.log(id);
            $.ajax({
                url: '{{ route('ticket') }}',
                type: 'get',
                data: {'id':id},
                success:function(data){
                    console.log('imprimiendo...');
                }
            });
        }
    </script>
    <script type="text/javascript">
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
    </script>
@endsection
