@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <div class="container center">
        <div class="row justify-content-center">
            <div class="col-md-3 col-md-5 col-md-3">
                <div class="">
                    <div class="">
                        <div class="card">
                            <form class="form-control" action="{{ route('guardar-fondo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('alerts.errores')
                                @if ($user->rol == 0)
                                    @if ($fondoId->fecha == date("Y-m-d"))
                                        <div class="card-header">
                                            <h5 class="card-title">Fondo</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="cantidad" class="col-md-3 col-form-label text-md-right">Fondo: $</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" id="cantidad" name="cantidad" value="{{ $fondoId->cantidad }}" disabled placeholder="Ingrese cantidad para iniciar">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-outline-primary" disabled>Aceptar</button>
                                            <!--<button type="button" class="btn btn-outline-secondary" >Cancelar</button>-->
                                        </div>
                                    @else
                                        <div class="card-header">
                                            <h3 class="card-title">Fondo</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="cantidad" class="col-md-3 col-form-label text-md-right">Fondo: $</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" id="cantidad" name="cantidad" value="{{ 1000 }}" required placeholder="Ingrese cantidad para iniciar">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#myModal">Aceptar</button>
                                        </div>
                                    @endif
                                @else
                                    <div class="card-header">
                                        <h3 class="card-title">Fondo</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="cantidad" class="col-md-3 col-form-label text-md-right">Fondo: $</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id="cantidad" name="cantidad" value="{{ 1000 }}" required placeholder="Ingrese cantidad para iniciar">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#myModal">Aceptar</button>
                                    </div>
                                @endif
                                <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"  id="exampleModalLabel">Fondo de caja</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="card-text">¿Desea agregar esa cantidad?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-outline-primary">Aceptar</button>
                                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
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
