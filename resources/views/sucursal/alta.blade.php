@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header"><h4>Alta sucursal</h4></div>

				<div class="card-body">
					<form class="" method="POST" action="{{ route('guardar') }}">
						@csrf
						<div class="form-group row">
							<label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre sucursal</label>
							<div class="col-md-6">
                <input class="form-control" type="text" name="nombre" id="nombresuc" placeholder="Nombre sucursal">
							</div>
						</div>

						<div class="form-group row">
							<label for="apellido" class="col-md-4 col-form-label text-md-right">Dirección</label>
							<div class="col-md-6">
                <input class="form-control" type="text" name="direccion" id="direccionsuc" placeholder="Dirección">
							</div>
						</div>

						<div class="form-group row">
							<label for="usuario" class="col-md-4 col-form-label text-md-right">Teléfono</label>
							<div class="col-md-6">
                <input class="form-control" type="text" name="telefono" id="telefonosuc" placeholder="Teléfono">
							</div>
						</div>

						<div class="form-group row">
								<label for="estatus" class="col-md-4 col-form-label text-md-right" hidden>{{ __('Estatus') }}</label>
								<div class="col-md-6">
								<input id="estatus_alta" type="number" class="form-control" name="estatus" value="{{ 1 }}" hidden required>
								</div>
						</div>

						<div class="form-group row">
							<div class="col-md-6 offset-md-4">
								<button type="submit" class="btn btn-outline-primary">Aceptar</button>
                <button type="button" class="btn btn-outline-secondary">Cancelar</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
