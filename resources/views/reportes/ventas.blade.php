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
                                        <button type="button" id="search_f" name="search" onclick="" class="btn btn-outline-primary form-control">Buscar</button>
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
                                      <button type="button" id="imprimir{{ $venta->id_venta }}" class="btn btn-outline-success" name="button"><i class="fa fa-print"></i> Imprimir</button>
                                    </td>
                                </tr>
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
        function imprimir(id) {
            $.ajax({
              type: 'get',
              url: '{{ route('venta.ticket') }}',
              data: {'id':id}
            });
        }
    </script>
@endsection
