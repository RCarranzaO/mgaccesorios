@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header"><h4>Alta sucursal</h4></div>

				<div class="card-body">

						<div class="form-group row">
							<label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre sucursal</label>
							<div class="col-md-6">
                <input class="form-control" type="text"  id="nombresuc" placeholder="Nombre sucursal">
							</div>
						</div>

						<div class="form-group row">
							<label for="apellido" class="col-md-4 col-form-label text-md-right">Dirección</label>
							<div class="col-md-6">
                <input class="form-control" type="search"  id="direccionsuc" placeholder="Dirección">
							</div>
						</div>

						<div class="form-group row">
							<label for="usuario" class="col-md-4 col-form-label text-md-right">Teléfono</label>
							<div class="col-md-6">
                <input class="form-control" type="tel" id="telefonosuc" placeholder="Teléfono">
							</div>
						</div>

            <div class="form-group row">
							<div class="col-md-6 offset-md-4">
								<button type="button" class="btn btn-outline-primary">Aceptar</button>
                <button type="button" class="btn btn-outline-secondary">Cancelar</button>
							</div>
						</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
