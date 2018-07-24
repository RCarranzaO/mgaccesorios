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
                  <h4 class="card-title">{{ 'Reporte de Ventas' }}</h4>
                </div>
                  <div class="card-body">
                    <table class="table table-bordered table-responsive-sm">
                            <tr>
                                <th >Ventas:</th>
                                <td>$200.00</td>
                            </tr>
                            <tr>
                                <th >Costos vendidos:</th>
                                <td class="table-danger">$110.00</td>
                            </tr>
                            <tr>
                                <th >Utilidad bruta:</th>
                                <td>$90.00</td>
                            </tr>
                            <tr>
                                <th >Gastos generales:</th>
                                <td class="table-danger">$30.00</td>
                            </tr>
                            <tr>
                                <th >Utilidad operacion:</th>
                                <td>$60.00</td>
                            </tr>
                            <tr>
                                <th >Gastos financieros:</th>
                                <td class="table-danger">$21.00</td>
                            </tr>
                            <tr>
                                <th >Utilidad antes de impuesto:</th>
                                <td>$39.00</td>
                            </tr>
                            <tr>
                                <th >Impuestos:</th>
                                <td class="table-danger">$15.60</td>
                            </tr>
                            <tr>
                                <th >Utilidad neta:</th>
                                <td>$23.40</td>
                            </tr>
                            <tr>
                                <th >Asigancion de dividendos:</th>
                                <td class="table-danger">$10.00</td>
                            </tr>
                            <tr>
                                <th >Utilidades retenidas:</th>
                                <td>$13.40</td>
                            </tr>
                      </table>
                  </div>
            </div>
            <!--<table class="table text-center table-responsive-sm">
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
            <hr>-->
        </div>

@endsection
