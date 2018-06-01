@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header"><h4>Compra Producto</h4></div>

				<div class="card-body">
					<form class="" method="POST" action="">
						@csrf
						<div class="form-group row">
							<label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre Producto</label>
							<div class="col-md-6">
								<input class="form-control" type="text" name="nombre" id="nombreproduc" placeholder="Nombre producto">
							</div>
						</div>

						<div class="form-group row">
							<label for="apellido" class="col-md-4 col-form-label text-md-right"> </label>
							<div class="col-md-6">
								<input class="form-control" type="text" name="" id="" placeholder="">
							</div>
						</div>

						<div class="form-group row">
							<label for="usuario" class="col-md-4 col-form-label text-md-right"> </label>
							<div class="col-md-6">
								<input class="form-control" type="text" name="" id="" placeholder=" ">
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
