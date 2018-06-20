@extends('layouts.app')
@section('content')
	@if (Auth::user()->rol == 1)
			<div class="container">
					<div class="row justify-content-center">
							<div class="col-md-8">
									@if (session('status'))
											<div class="alert alert-success">
													{{ session('status') }}
											</div>
									@endif
									<div class="card">
											<div class="card-header"><h4>Dar alta un producto</h4></div>
											<div class="card-body">

													@if (session('message'))
															<div class="alert alert-danger">
																	{{ session('message') }}
															</div>
													@endif

													<form method="post" action="{{ route('producto.store') }}">
															@csrf
															@if($errors->any())
																	<div class="alert alert-danger">
																			<ul>
																					@foreach($errors->all() as $error)
																							<li>{{$error}}</li>
																					@endforeach
																			</ul>
																	</div>
															@endif
															<div class="form-group row">
																	<label for="referencia" class="col-md-4 col-form-label text-md-right">Referencia</label>

																	<div class="col-md-6">
																			<input id="referencia" type="text" class="form-control{{ $errors->has('referencia') ? ' is-invalid' : '' }}" name="referencia" value="{{ old('referencia') }}" required>

																			@if($errors->has('referencia'))
																					<span class="invalid-feedback">
																							<strong>{{ $errors->first('referencia') }}</strong>
																					</span>
																			@endif

																	</div>
															</div>

															<div class="form-group row">
																	<label for="categoria" class="col-md-4 col-form-label text-md-right">Categoria</label>

																	<div class="col-md-6">
																			<input id="categoria" type="text" class="form-control{{ $errors->has('categoria') ? ' is-invalid' : '' }}" name="categoria" value="{{ old('categoria') }}" required>

																			@if($errors->has('categoria'))
																					<span class="invalid-feedback">
																							<strong>{{ $errors->first('categoria') }}</strong>
																					</span>
																			@endif

																	</div>
															</div>

															<div class="form-group row">
																	<label for="tipo" class="col-md-4 col-form-label text-md-right">Tipo</label>

																	<div class="col-md-6">
																			<input id="tipo" type="text" class="form-control{{ $errors->has('tipo') ? ' is-invalid' : '' }}" name="tipo" value="{{ old('tipo') }}" required>

																			@if($errors->has('tipo'))
																					<span class="invalid-feedback">
																							<strong>{{ $errors->first('tipo') }}</strong>
																					</span>
																			@endif

																	</div>
															</div>

															<div class="form-group row">
																	<label for="marca" class="col-md-4 col-form-label text-md-right">Marca</label>

																	<div class="col-md-6">
																			<input id="marca" type="text" class="form-control{{ $errors->has('marca') ? ' is-invalid' : '' }}" name="marca" value="{{ old('marca') }}" required>

																			@if($errors->has('marca'))
																					<span class="invalid-feedback">
																							<strong>{{ $errors->first('marca') }}</strong>
																					</span>
																			@endif

																	</div>
															</div>

															<div class="form-group row">
																	<label for="modelo" class="col-md-4 col-form-label text-md-right">Modelo</label>

																	<div class="col-md-6">
																			<input id="modelo" type="text" class="form-control{{ $errors->has('modelo') ? ' is-invalid' : '' }}" name="modelo" value="{{ old('modelo') }}" required>

																			@if($errors->has('modelo'))
																					<span class="invalid-feedback">
																							<strong>{{ $errors->first('modelo') }}</strong>
																					</span>
																			@endif

																	</div>
															</div>

															<div class="form-group row">
																	<label for="color" class="col-md-4 col-form-label text-md-right">Color</label>

																	<div class="col-md-6">
																			<input id="color" type="text" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" name="color" value="{{ old('color') }}" required>

																			@if($errors->has('color'))
																					<span class="invalid-feedback">
																							<strong>{{ $errors->first('color') }}</strong>
																					</span>
																			@endif

																	</div>
															</div>

															<div class="form-group row">
																	<label for="precio_compra" class="col-md-4 col-form-label text-md-right">Precio de compra</label>

																	<div class="col-md-6">
																			<input id="precio_compra" type="number" class="form-control{{ $errors->has('precio_compra') ? ' is-invalid' : '' }}" name="precio_compra" min="1" value="{{ old('precio_compra') }}" required>

																			@if($errors->has('precio_compra'))
																					<span class="invalid-feedback">
																							<strong>{{ $errors->first('precio_compra') }}</strong>
																					</span>
																			@endif

																	</div>
															</div>

															<div class="form-group row">
																	<label for="precio_venta" class="col-md-4 col-form-label text-md-right">Precio de venta</label>

																	<div class="col-md-6">
																			<input id="precio_venta" type="number" class="form-control{{ $errors->has('precio_venta') ? ' is-invalid' : '' }}" name="precio_venta" min="1" value="{{ old('precio_venta') }}" required>

																			@if($errors->has('precio_venta'))
																					<span class="invalid-feedback">
																							<strong>{{ $errors->first('precio_venta') }}</strong>
																					</span>
																			@endif

																	</div>
															</div>

															<div class="form-group row">
																	<label for="estatus" class="col-md-4 col-form-label text-md-right" hidden>Estatus</label>

																	<div class="col-md-6">
																			<input id="estatus" type="text" class="form-control" name="estatus" value="{{ 1 }}" hidden required>

																	</div>
															</div>

															<div class="form-group row">
																	<div class="col-md-6 offset-md-4">

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
