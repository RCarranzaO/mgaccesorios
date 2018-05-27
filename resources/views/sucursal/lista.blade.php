@extends('layouts.app')
@section('content')
@if (Auth::user()->rol == 1)
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
            <form method="POST" class="" action="/eliminar/{{ $sucursal->id_sucursal }}">
              @csrf
              @method('DELETE')
              <button type="submit" value="{{$sucursal->estatus==1 ? '0' : '1'}}" name="estatus" class="btn btn-outline-danger">
                Baja
              </button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@else
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#myModal").modal("show");
        });
    </script>
    <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"  id="exampleModalLabel">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">No tienes lo privilegios para entrar aquí!! Adios!</p>
                </div>
                <div class="modal-footer">
                    <form class="" action="{{ route('home') }}">
                        <button type="submit" class="btn btn-outline-primary">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif



@endsection
