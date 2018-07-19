@extends('layouts.app')
@section('content')
<script src="{{ asset('js/jquery/jquery-3.3.1.min.js') }}"></script>

		<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-8">
						<div class="">
								<div class="">
										<div class="card">
												<div class="card-header"><h4>Compra Producto</h4></div>
												<div class="card-body">
														<form class="form-control" method="POST" action="{{ route('almacen.store') }}">
																@csrf
																@include('alerts.errores')
																<div class="form-group row">
																		<label for="refproduc" class="col-md-4 col-form-label text-md-right">Referencia Producto </label>
																		<div class="col-md-6">
																			<select class="form-control select-search {{ $errors->has('refproduc') ? ' is-invalid' : '' }}" name="refproduc" required>
																					<option>Elija una opcion</option>
																					@foreach ($productos as $producto)
																							@if ($producto->estatus != 0)
																									<option value={{$producto->id_producto}}>{{$producto->referencia}} - {{$producto->categoria_producto}}, {{$producto->tipo_producto}}, {{$producto->marca}}, {{$producto->modelo}}, {{$producto->color}}</option>
																							@endif
																					@endforeach
																			</select>
																		</div>
																		@if($errors->has('refproduc'))
																				<span class="invalid-feedback">
																						<strong>{{ $errors->first('refproduc') }}</strong>
																				</span>
																		@endif
																</div>

																<div class="form-group row">
																		<label  class="col-md-4 col-form-label text-md-right">Existencia Producto</label>
																		<div class="col-md-6">
																				<input class="form-control{{ $errors->has('exisproduc') ? ' is-invalid' : '' }}" type="number" min="1" name="exisproduc" id="exisproduc" placeholder="Existencia producto" required>
																		</div>
																		@if($errors->has('exisproduc'))
																				<span class="invalid-feedback">
																						<strong>{{ $errors->first('exisproduc') }}</strong>
																				</span>
																		@endif
																</div>

																<div class="form-group row">
																		<label class="col-md-4 col-form-label text-md-right">Sucursal Producto</label>
																		<div class="col-md-6">
																				<select class="form-control{{ $errors->has('sucproduc') ? ' is-invalid' : '' }}" name="sucproduc" required>
																						<option>Elija una opcion</option>
																						@foreach ($sucursales as $sucursal)
																								@if ($sucursal->estatus != 0)
																										<option value="{{$sucursal->id_sucursal}}">{{$sucursal->nombre_sucursal}}</option>
																								@endif
																						@endforeach
																				</select>
																				@if($errors->has('sucproduc'))
																						<span class="invalid-feedback">
																								<strong>{{ $errors->first('sucproduc') }}</strong>
																						</span>
																				@endif
																		</div>
																</div>

																<div class="form-group row">
																		<div class="col-md-9 offset-md-3">
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

@endsection
