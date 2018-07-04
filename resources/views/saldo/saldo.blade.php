@extends('layouts.app')
@section('content')

    <div class="container center">
        <div class="row justify-content-center">
            <div class="col-md-3 col-md-6 col-md-3">
                <div class="">
                    <div class="">
                        <div class="card">
                            <form class="form-control" action="{{ route('home') }}">
                                @csrf
                                <div class="card-header">
                                    <h5 class="card-title">Saldo</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="cantidad" class="col-md-3 col-form-label text-md-right">Saldo: $</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" id="cantidad" name="cantidad" value="{{$saldo->fecha == $date ? $saldo->saldo_actual : 'No se ha ingresado un fondo' }}" disabled >
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!--<button type="submit" class="btn btn-outline-primary">Aceptar</button>-->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<script type="text/javascript">
        $(document).ready(function()
        {
            $("#myModal").modal("show");
        });
    </script>-->


@endsection
