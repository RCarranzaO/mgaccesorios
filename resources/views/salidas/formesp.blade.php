@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="">
                    <div class="">
                        @include('alerts.errores')
                        <div class="card">
                            <div class="card-header"><h4>Salida especial de producto</h4></div>
                            <div class="card-body">
                                <form class="form-control" method="POST" action="{{ route('salidasesp.store') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="cantidad" class="col-md-4 col-form-label text-md-right">Cantidad a retirar:</label>
                                        <div class="col-md-6">
                                            <input class="form-control{{ $errors->has('cantidad') ? ' is-invalid' : '' }}" type="text" name="cantidad" placeholder="Ingrese cantidad a retirar" required>
                                        </div>
                                        @if($errors->has('cantidad'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('cantidad') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group row">
                                        <label for="descripcion" class="col-md-4 col-form-label text-md-right">Razon de retiro: </label>
                                        <div class="col-md-6">
                                            <textarea class="form-control {{ $errors->has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" rows="5" cols="80" placeholder="Escriba la razon del retiro..." required></textarea>
                                        </div>
                                        @if($errors->has('descripcion'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('descripcion') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4 offset-md-4">
                                            <button type="submit" class="btn btn-outline-primary">Aceptar</button>
                                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Cancelar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
