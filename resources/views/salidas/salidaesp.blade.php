@extends('layouts.app')
@section('content')
    <div class="container">
        @foreach ($sucursales as $sucursal)
            <form class="form-control" action="/salidasesp/{{ $sucursal->id_sucursal }}" method="post">
                <button type="submit" class="btn btn-outline-primary" name="sucursal{{ $sucursal->id_sucursal }}" value="{{ $sucursal->id_sucursal }}">{{ $sucursal->nombre_sucursal }}</button>
            </form>
        @endforeach
        <table class="table text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Referencia</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @if ($salidas->count())
                    @foreach ($salidas as $salida)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
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
        {{ $salidas->links() }}
    </div>
@endsection
