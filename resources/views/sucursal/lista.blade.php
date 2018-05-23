@extends('layouts.app')
@section('content')

<div class="container">
  <table class="table text-center">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Dirección</th>
        <th scope="col">Teléfono</th>
        <th scope="col"></th>
      </tr>
    </thead>

    <tbody>
      @foreach($sucursales as $sucursal)
        <tr>
          <td>{{ $sucursal->nombre_sucursal }}</td>
          <td>{{ $sucursal->direccion }}</td>
          <td>{{ $sucursal->telefono }}</td>
          <td>
              <button type="submit" class="btn btn-outline-danger">Eliminar</button>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table
</div>
@endsection
