@extends('layouts.app')

@section('content')
<script src="{{ asset('js/jquery/jquery-3.3.1.min.js') }}"></script>
    <div class="container center">
        <div class="row justify-content-center">
            <div class="content">
                <div class="">
                    <div class="">
                        @include('alerts.success')
                        <div class="card">
                            <form class="form-control" action="{{ route('guardar-gasto') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('alerts.errores')
                                <div class="card-header">
                                    <h5 class="card-title">Gastos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="cantidad" class="col-md-3 col-form-label text-md-right">Cantidad: $</label>
                                        <div class="col-md-7">
                                            <input type="number" min="1" class="form-control {{ $errors->has('cantidad') ? ' is-invalid' : '' }}" name="cantidad" placeholder="Ingrese cantidad" required>
                                        </div>
                                        @if($errors->has('cantidad'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('cantidad') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group row">
                                        <label for="descripcion" class="col-md-3 col-form-label text-md-right"> Descripción: </label>
                                        <div class="col-md-7">
                                            <textarea class="form-control {{ $errors->has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" rows="5" cols="80" placeholder="Descripcion..." required></textarea>
                                        </div>
                                        @if($errors->has('descripcion'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('descripcion') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#myModal">Aceptar</button>
                                </div>
                                <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"  id="exampleModalLabel">Gasto</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="card-text">¿Desea ingresar el gasto?</p>
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
@endsection
