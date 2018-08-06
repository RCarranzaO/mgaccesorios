@extends('layouts.app')
@section('content')

        <div class="container">
            @if (Auth::user()->rol == 1)
            <!--<p>
                <a href="{{ route('almacen.pdf') }}" class="btn btn-sm btn-primary">
                Descargar productos en PDF
              </a>
            </p>-->
            @endif
            <div class="card">
                <div class="card-header background-light">
                    <h4 class="card-title"><i class="fa fa-calendar"></i> {{ 'Reporte de Ventas' }}</h4>
                    <br>
                    <div class="container">
                        <form class="" action="#" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fecha_i">Desde:</label>
                                        <input class="form-control" type="date" id="fecha_i" name="fecha_i" min="1980-01-01" max="3000-12-31">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fecha_f">Hasta:</label>
                                        <input class="form-control" type="date" id="fecha_f" name="fecha_f" min="1980-01-01" max="3000-12-31">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="search" >.  </label>
                                        <button type="button" id="search_f" name="search" onclick="" class="btn btn-outline-primary form-control"><i class="fa fa-search"></i>Buscar</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="print" >.  </label>
                                        <button type="button" id="print" name="print" onclick="" class="btn btn-outline-primary form-control"><i class="fa fa-print"></i>Imprimir</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-responsive-sm">
                      <thead>
                          <tr>
                              <th># Folio</th>
                              <th>Fecha</th>
                              <th>Empleado</th>
                              <th>Sucursal</th>
                              <th>Estado</th>
                              <th>Total</th>
                              <th>Ticket</th>
                          </tr>
                      </thead>
                      @if ($ventas->count())
                          <tbody id="ventas">
                              @foreach ($ventas as $venta)
                                <tr>
                                    <td>{{ $venta->id_venta }}</td>
                                    <td>{{ $venta->fecha }}</td>
                                    <td>{{ $venta->username }}</td>
                                    <td>{{ $venta->nombre_sucursal }}</td>
                                    <td>
                                        @if($venta->estatus == 1)
                                            {{ $rol = 'Finalizada' }}
                                        @else
                                            {{ $rol = 'Cancelada' }}
                                        @endif
                                    </td>
                                    <td>{{ $venta->monto_total }}</td>
                                    <td>
                                        <button type="button" onclick="imprimir({{ $venta->id_venta }})" class="btn btn-outline-success" name="button"><i class="fa fa-print"></i> Imprimir</button>
                                    </td>
                                </tr>
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
                                                                <div class="card-body" id="modal_ticket">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{ route('venta.pdf', $venta->id_venta) }}" class="btn btn-outline-success">Imprimir</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              @endforeach
                          </tbody>
                      @else
                          <tbody id="ventas">
                              <tr>
                                  <td colspan="7" class="text-center">No hay registro de ventas</td>
                              </tr>
                          </tbody>
                      @endif
                  </table>
                  <hr>
                  {{ $ventas->links() }}

              </div>
          </div>

      </div>
@endsection
@section('script')
    <script>
      $("#search_f").on("click", function () {
          var fecha_i = $("#fecha_i").val();
          var fecha_f = $("#fecha_f").val();
          $.ajax({
              type: 'get',
              url: '{{ route('venta.buscar') }}',
              data: {'fecha_i':fecha_i, 'fecha_f':fecha_f},
              success:function (data) {
                  $('#ventas').html(data);
              }
          });
      });
    </script>
    <script>
    $("#print").on("click", function () {
        var fecha_i = $("#fecha_i").val();
        var fecha_f = $("#fecha_f").val();
        $.ajax({
            type: 'get',
            url: '{{ route('reporte.pdf') }}',
            data: {'fecha_i':fecha_i, 'fecha_f':fecha_f}

        });
    });
    </script>
    <script>
        function imprimir(id) {
            console.log(id);
            $.ajax({
              type: 'get',
              url: '{{ route('venta.ticket') }}',
              data: {'id':id},
              success:function(data) {
                  $('#ModalImprimir').modal('show');
                  $('#modal_ticket').html(data);
              }
            });
        }
    </script>
@endsection
