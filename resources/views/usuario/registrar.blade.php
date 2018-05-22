@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header"><h4>Registrar usuario nuevo</h4></div>

				<div class="card-body">
					<form method="post" action="/usuario">
						@csrf

						<div class="form-group row">
							<label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>

							<div class="col-md-6">
								<input id="nombre" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('nombre') }}" required>

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
								<input id="apellido" type="text" class="form-control{{ $errors->has('apellido') ? ' is-invalid' : '' }}" name="apellido" value="{{ old('apellido') }}" required>

								@if($errors->has('apellido'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('apellido') }}</strong>
									</span>
								@endif

							</div>
						</div>

						<div class="form-group row {{ $errors->has('usuario') ? 'has-error' : '' }}">
							<label for="usuario" class="col-md-4 col-form-label text-md-right">Usuario</label>

							<div class="col-md-6">
								<input id="usuario" type="text" class="form-control" name="usuario" value="{{ old('usuario') }}" required maxlength="20">

								@if($errors->has('usuario'))
									<span class="help-block">
										<strong>{{ $errors->first('usuario') }}</strong>
									</span>
								@endif

							</div>
						</div>

						<div class="form-group row {{ $errors->has('correo') ? 'has-error' : '' }}">
							<label for="correo" class="col-md-4 col-form-label text-md-right">Correo</label>

							<div class="col-md-6">
								<input id="correo" type="text" class="form-control" name="correo" value="{{ old('correo') }}" required>

								@if($errors->has('correo'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('correo') }}</strong>
									</span>
								@endif

							</div>
						</div>

						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

							<div class="col-md-6">
								<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

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
								<select class="form-control{{ $errors->has('rol') ? ' is-invalid' : '' }}" name="rol" required>
									<option>Elija una opcion</option>
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
							<div class="col-md-6 offset-md-4">
								<button type="submit" class="btn btn-primary">Aceptar</button>
								<button class="btn btn-secondary">Cancelar</button>
							</div>
						</div>

					</form>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection
