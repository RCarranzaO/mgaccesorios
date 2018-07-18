@extends('layouts.app')
@section('content')
    <div class="container">
      <div class="card">
        <div class="card-body">
        <table class="table text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Referencia</th>
                    <th scope="col">Existencia</th>
                    <th scope="col" colspan="2">Cantidad a retirar</th>
                </tr>
            </thead>
            <tbody>
                @if ($salidas->count())
                    @foreach ($salidas as $salida)
                        <tr>
                            <td>{{ $salida->referencia }}</td>
                            <td>{{ $salida->existencia }}</td>
                            <td>
                                <a href="{{ route('salidasesp.show', $salida->id_producto) }}" class="btn btn-outline-info">Retirar</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8"> <h3>No hay registros!!</h3> </td>
                    </tr>
                @endif
            </tbody>
        </table>
        </div>
      </div>
    </div>
@endsection
