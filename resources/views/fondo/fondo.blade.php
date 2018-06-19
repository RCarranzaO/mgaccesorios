@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <div class="flex-center position-ref full-height">
        <div class="row justify-content-center">
            <div class="content">
                <div class="row">
                    <div class="col-offset-md-4 col-md-6">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="card" style="width: 30rem;">
                            <form class="form-control" action="{{ route('guardar-fondo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
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
                                                <button type="submit" class="btn btn-outline-primary" data-toogle="modal" data-target="#myModal">Aceptar</button>
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
