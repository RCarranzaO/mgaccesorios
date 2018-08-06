@extends('layouts.app')

@section('content')

		@if (Auth::user()->rol == 1)
				<div class="container">
						<div class="row justify-content-center">
								<div class="col-md-8">
										<div class="card">
												<div class="card-header"><h4>Registrar usuario nuevo</h4></div>
												<div class="card-body">
														<form method="post" action="{{ route('usuario.store') }}">
																@csrf
																@include('alerts.errores')
																<div id="msg" class="col-sm"></div>

																<div class="form-group row">
																		<label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>
																		<div class="col-md-6">
																				<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
																				@if($errors->has('name'))
																						<span class="invalid-feedback">
																								<strong>{{ $errors->first('name') }}</strong>
																						</span>
																				@endif
																		</div>
																</div>

																<div class="form-group row">
																		<label for="apellido" class="col-md-4 col-form-label text-md-right">Apellido</label>
																		<div class="col-md-6">
																				<input type="text" class="form-control {{ $errors->has('apellido') ? ' is-invalid' : '' }}" name="apellido" value="{{ old('apellido') }}" required>
																				@if($errors->has('apellido'))
																						<span class="invalid-feedback">
																								<strong>{{ $errors->first('apellido') }}</strong>
																						</span>
																				@endif
																		</div>
																</div>

																<div class="form-group row ">
																		<label for="username" class="col-md-4 col-form-label text-md-right">Usuario</label>
																		<div class="col-md-6">
																				<input type="text" class="form-control {{ $errors->has('username') ? 'has-error' : '' }}" name="username" value="{{ old('username') }}" required maxlength="20">
																				@if($errors->has('username'))
																						<span class="help-block">
																								<strong>{{ $errors->first('username') }}</strong>
																						</span>
																				@endif
																		</div>
																</div>

																<div class="form-group row">
																		<label for="email" class="col-md-4 col-form-label text-md-right">Correo</label>
																		<div class="col-md-6">
																				<input type="text" class="form-control {{ $errors->has('email') ? 'has-error' : '' }}" name="email" value="{{ old('email') }}" required>
																				@if($errors->has('email'))
																						<span class="invalid-feedback">
																								<strong>{{ $errors->first('email') }}</strong>
																						</span>
																				@endif
																		</div>
																</div>

																<div class="form-group row">
																		<label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
																		<div class="col-md-6">
																				<input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
																				@if($errors->has('password'))
																						<span class="invalid-feedback">
																								<strong>{{ $errors->first('password') }}</strong>
																						</span>
																				@endif
																		</div>
																</div>

																<div class="form-group row">
																		<label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar password</label>
																		<div class="col-md-6">
																				<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
																		</div>
																</div>

																<div class="form-group row">
																		<label for="rol" class="col-md-4 col-form-label text-md-right">Rol</label>
																		<div class="col-md-6">
																				<select id="rol" class="form-control{{ $errors->has('rol') ? ' is-invalid' : '' }}" name="rol" required>
																						<option value="2">Elija una opcion</option>
																						<option value="0">Vendedor</option>
																						<option value="1">Administrador</option>
																				</select>
																				@if($errors->has('rol'))
																						<span class="invalid-feedback">
																								<strong>{{ $errors->first('rol') }}</strong>
																						</span>
																				@endif
																		</div>
																</div>

																<div class="form-group row">
																		<label for="sucursal" class="col-md-4 col-form-label text-md-right">Sucursal</label>
																		<div class="col-md-6">
																				<select id="sucursal" class="form-control{{ $errors->has('sucursal') ? ' is-invalid' : '' }}" name="sucursal" required>
																						<option value="0">Elija una opcion</option>
																						@foreach ($sucursales as $sucursal)
																								@if ($sucursal->estatus != 0)
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
																		<label for="estatus" class="col-md-4 col-form-label text-md-right" hidden>{{ __('Estatus') }}</label>
																		<div class="col-md-6">
																				<input id="estatus" type="number" class="form-control" name="estatus" value="{{ 1 }}" hidden required>
																		</div>
																</div>

																<div class="form-group row">
																		<div class="col-md-6 offset-md-4">
																				<button id="aceptar" type="button" class="btn btn-outline-primary">Aceptar</button>
																				<a href="{{ route('home') }}" class="btn btn-outline-secondary">Cancelar</a>
																		</div>
																</div>
																<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																				<div class="modal-content">
																						<div class="modal-header">
																								<h5 class="modal-title"  id="exampleModalLabel">{{ "Alta de Usuario" }}</h5>
																								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																										<span aria-hidden="true">&times;</span>
																								</button>
																						</div>
																						<div class="modal-body">
																								<p class="card-text">{{ "¿Desea registrar al usuario?" }}</p>
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
@section('script')
	<script>
		$(document).ready(function(){
			$('#aceptar').click(function(){
				validar();
			});
			function validar(){
				var rol = $("#rol").val();
				var sucursal = $("#sucursal").val();
				if(rol > 1 && sucursal == 0){
					$('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Hay campos vacíos.</div>');
				}else if (rol > 1 && sucursal != 0) {
					$('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Debe elegir un rol para el usuario.</div>');
				}else if (rol <= 1 && sucursal == 0) {
					$('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Debe elegir una sucursal para el usuario.</div>');
				}
				else{
					$("#myModal").modal();
				}
			}
		});
	</script>
@endsection
