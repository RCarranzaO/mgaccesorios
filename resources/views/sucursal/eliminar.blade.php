@extends('layouts.app')
@section('content')

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $("#Modal").modal("show");
    });
</script>
<div class="modal" id="Modal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Eliminar</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          Desea Eliminar
        </div>

        <div class="modal-footer">
          <form method="POST" action="{{ route('sucursal.destroy', $sucursal->id_sucursal) }}">
            <button type="submit" value="{{sucursala}}" class="btn btn-outline-primary" data-dismiss="modal">Aceptar</button>
          </form>

          <button type="submit" class="btn btn-outline-danger" data-dismiss="modal" href="{{ route('home') }}">Cancelar</button>
        </div>

      </div>
    </div>
  </div>
@endsection
