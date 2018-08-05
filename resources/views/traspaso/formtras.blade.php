@extends('layouts.app')
@section('content')

    <div class="container center">
        <div class="row justify-content-center">
            <div class="col-md-3 col-md-6 col-md-3">
                <div class="">
                    <div class="">
                        @include('alerts.errores')
                        <div class="card">
                            <div class="card-header"><h4>Traspaso de producto</h4></div>
                            <div class="card-body">
                                <form class="form-control" method="POST" action="{{ route('traspaso.store') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="cantidad" class="col-md-4 col-form-label text-md-right">Cantidad a retirar:</label>
                                        <div class="col-md-6">
                                            <input class="form-control{{ $errors->has('cantidad') ? ' is-invalid' : '' }}" type="number" min="1" name="cantidad" placeholder="Ingrese cantidad a retirar" required>
                                        </div>
                                        @if($errors->has('cantidad'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('cantidad') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group row">
                      									<label for="sucursal" class="col-md-4 col-form-label text-md-right">Sucursal Destino</label>

                      									<div class="col-md-6">
                        										<select class="form-control{{ $errors->has('sucursal') ? ' is-invalid' : '' }}" name="sucursal" required>
                          											<option>Elija una opcion</option>
                          											@foreach ($sucursales as $sucursal)
                            												@if ($sucursal->estatus != 0 && $sucursal->id_sucursal != $usuario->id_sucursal)
                            													             <option value="{{$sucursal->id_sucursal}}">{{$sucursal->nombre_sucursal}}</option>
                            												@endif
                          											@endforeach
                          									</select>
                          									@if($errors->has('sucursal'))
                          											<span class="invalid-feedback">
                          											    <strong>{{ $errors->first('sucursal') }}</strong>
                          											</span>
                        										@endif
                    									</div>
                  								</div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-outline-primary">Aceptar</button>
                                            <a href="{{ route('traspaso.index') }}" class="btn btn-outline-secondary">Cancelar</a>
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
