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
        </div>

@endsection
