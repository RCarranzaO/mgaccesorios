@extends('layouts.app')

@section('content')

@if (Auth::user()->rol == 1)
		<div class="container">
				<div class="row justify-content-center">
						<div class="col-md-8">
								<div class="card">
										<div class="card-header"><h4>Actualizar usuario</h4></div>
										<div class="card-body">
												<form method="post" action="/usuario/{{ $usuario->id_user }}">
														@csrf
														<input type="hidden" name="_method" value="PATCH">

														<div class="form-group row">
																<label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>
																<div class="col-md-6">
																		<input id="nombre" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ $usuario->name }}" required>
																		@if($errors->has('nombre'))
																				<span class="invalid-feedback">
																						<strong>{{ $errors->first('nombre') }}</strong>
																				</span>
																		@endif
																</div>
														</div>

														<div class="form-group row">
																<label for="apellido" class="col-md-4 col-form-label text-md-right">Apellido</label>
																<div class="col-md-6">
																		<input id="apellido" type="text" class="form-control{{ $errors->has('apellido') ? ' is-invalid' : '' }}" name="apellido" value="{{ $usuario->lastname }}" required>
																		@if($errors->has('apellido'))
																				<span class="invalid-feedback">
																						<strong>{{ $errors->first('apellido') }}</strong>
																				</span>
																		@endif
																</div>
														</div>

														<div class="form-group row">
																<label for="usuario" class="col-md-4 col-form-label text-md-right">Usuario</label>
																<div class="col-md-6">
																		<input id="usuario" type="text" class="form-control{{ $errors->has('usuario') ? ' is-invalid' : '' }}" name="usuario" value="{{ $usuario->username }}" required>
																		@if($errors->has('usuario'))
																				<span class="invalid-feedback">
																						<strong>{{ $errors->first('usuario') }}</strong>
																				</span>
																		@endif
																</div>
														</div>

														<div class="form-group row {{ $errors->has('correo') ? 'has-error' : '' }}">
																<label for="correo" class="col-md-4 col-form-label text-md-right">Correo</label>
																<div class="col-md-6">
																		<input id="correo" type="text" class="form-control" name="correo" value="{{ $usuario->email }}" required>
																		@if($errors->has('correo'))
																				<span class="invalid-feedback">
																						<strong>{{ $errors->first('correo') }}</strong>
																				</span>
																		@endif
																</div>
														</div>

														<div class="form-group row">
																<label for="password" class="col-md-4 col-form-label text-md-right">Nueva Password</label>
																<div class="col-md-6">
																		<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ $usuario->password }}" name="password">
																</div>
														</div>

														<div class="form-group row">
																<label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar password</label>
																<div class="col-md-6">
																		<input id="password-confirm" type="password" class="form-control" value="{{ $usuario->password }}" name="password_confirmation">
																</div>
														</div>

														<div class="form-group row">
																<label for="rol" class="col-md-4 col-form-label text-md-right">Rol</label>
																<div class="col-md-6">
																		<select class="form-control{{ $errors->has('rol') ? ' is-invalid' : '' }}" name="rol" required>
																				<option value="@if($usuario->rol == 1) {{ 1 }} @else {{ 0 }} @endif">
																						@if($usuario->rol == 1)
																								{{ $rol = 'Administrador' }}
																						@else
																								{{ $rol = 'Vendedor' }}
																						@endif
																				</option>
																				<option value="@if($usuario->rol == 1) {{ 0 }} @else {{ 1 }} @endif">
																						@if($usuario->rol == 1)
																								{{ $rol = 'Vendedor' }}
																						@else
																								{{ $rol = 'Administrador' }}
																						@endif
																				</option>
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
																		<select class="form-control{{ $errors->has('sucursal') ? ' is-invalid' : '' }}" name="sucursal" required>
																				<option value="{{$sucursales->id_sucursal}}">{{$sucursales->nombre_sucursal}}</option>
																				@foreach ($sucursalId as $sucursal)
																						@if ($sucursal->id_sucursal != $sucursales->id_sucursal)
																								<option value={{$sucursal->id_sucursal}}>{{$sucursal->nombre_sucursal}}</option>
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

														<div class="form-group">
																<div class="col-md-8 offset-md-3">
																		<button type="submit" class="btn btn-outline-primary">Aceptar</button>
																		<button class="btn btn-outline-primary" type="submit"  name="action" value="aym">Aceptar y modificar</button>
																		<a href="{{ route('home') }}" class="btn btn-outline-secondary">Cancelar</a>
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
