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
                      <form class="" action="" method="post">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="input-group" id="datetimepicker1">
                              <input type="date" name="bday" max="3000-12-31" min="1980-01-01" class="form-control">
                              <span class="input-group-btn"><button type="button" class="btn btn-outline-default"><i class="fa fa-calendar"></i></button></span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="input-group" id="datetimepicker1">
                              <input type="date" name="bday"min="1980-01-01" max="3000-12-31" class="form-control">
                              <span class="input-group-btn"><button type="button" class="btn btn-outline-default"><i class="fa fa-calendar"></i></button></span>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary">Buscar</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
                  <div class="card-body">
                    <table class="table table-bordered table-responsive-sm">
                      <thead>
                          <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Empleado</th>
                            <th>Número</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>ID</th>
                            <th>Ver</th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr>
                            <td>1</td>
                            <td>Publico General</td>
                            <td>29/07/2018</td>
                            <td>Juan</td>
                            <td>V000001</td>
                            <td>Pagado</td>
                            <td>$150.00</td>
                            <td>1</td>
                            <td><i class="fa fa-search"></i></td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Publico General</td>
                            <td>29/07/2018</td>
                            <td>Juan</td>
                            <td>V000002</td>
                            <td>Pagado</td>
                            <td>$150.00</td>
                            <td>1</td>
                            <td><i class="fa fa-search"></i></td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>Publico General</td>
                            <td>29/07/2018</td>
                            <td>Juan</td>
                            <td>V000003</td>
                            <td>Pagado</td>
                            <td>$150.00</td>
                            <td>1</td>
                            <td><i class="fa fa-search"></i></td>
                          </tr>
                          </tbody>
                      </table>
                  </div>
            </div>
        </div>

        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
@endsection
