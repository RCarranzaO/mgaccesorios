@extends('layouts.app')
@section('content')
    <div class="container">
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
                            <td colspan="2">
                                <form class="" action="index.html" method="post">
                                   <input type="number" name="cantidad">
                                   &nbsp;&nbsp;&nbsp;
                                   <button type="submit" class="btn btn-outline-primary">Retirar</button>
                                </form>
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
        <hr>
    </div>
@endsection
