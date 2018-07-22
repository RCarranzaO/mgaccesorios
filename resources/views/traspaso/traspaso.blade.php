@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table class="table text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Referencia</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Existencia</th>
                            <th scope="col" colspan="2">Cantidad a retirar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($traspasos->count())
                            @foreach ($traspasos as $traspaso)
                                <tr>
                                    <td>{{ $traspaso->referencia }}</td>
                                    <td>{{ $traspaso->categoria_producto }}, {{ $traspaso->tipo_producto }}, {{ $traspaso->marca }}, {{ $traspaso->modelo }}, {{ $traspaso->color }}</td>
                                    <td>{{ $traspaso->existencia }}</td>
                                    <td>
                                        <a href="{{ route('traspaso.show', $traspaso->id_producto) }}" class="btn btn-outline-info">Traspasar</a>
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
