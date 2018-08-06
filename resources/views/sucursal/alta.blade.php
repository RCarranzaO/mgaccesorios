@extends('layouts.app')
@section('content')
@if (Auth::user()->rol == 1)
		<div class="container">
				<div class="row justify-content-center">
						<div class="col-md-8">

								<div class="card">
										<div class="card-header"><h4>Alta sucursal</h4></div>
										<div class="card-body">
												<form class="form-control" method="post" action="{{ route('sucursal.store') }}">
														@csrf
														@include('alerts.errores')
														<div id="msg" class="col-sm"></div>

														<div class="form-group row">
																<label for="nombre_sucursal" class="col-md-4 col-form-label text-md-right">Nombre sucursal</label>
																<div class="col-md-6">
																		<input id="nombre_sucursal" class="form-control {{ $errors->has('nombre_sucrusal') ? ' is-invalid' : '' }}" type="text" name="nombre_sucursal" placeholder="Nombre sucursal" required>
																		@if($errors->has('nombre_sucursal'))
																				<span class="help-block">
																						<strong>{{ $errors->first('nombre_sucursal') }}</strong>
																				</span>
																		@endif
																</div>
														</div>

														<div class="form-group row">
																<label for="direccion" class="col-md-4 col-form-label text-md-right">Dirección</label>
																<div class="col-md-6">
																		<input id="direccion" class="form-control {{ $errors->has('direccion') ? ' is-invalid' : '' }}" type="text" name="direccion" placeholder="Dirección" required>
																		@if($errors->has('direccion'))
																				<span class="invalid-feedback">
																						<strong>{{ $errors->first('direccion') }}</strong>
																				</span>
																		@endif
																</div>
														</div>

														<div class="form-group row">
																<label for="telefono" class="col-md-4 col-form-label text-md-right">Teléfono</label>
																<div class="col-md-6">
																		<input id="telefono" class="form-control {{ $errors->has('telefono') ? ' is-invalid' : '' }}" type="text" name="telefono" placeholder="Teléfono" required>
																		@if($errors->has('telefono'))
																				<span class="invalid-feedback">
																						<strong>{{ $errors->first('telefono') }}</strong>
																				</span>
																		@endif
																</div>
														</div>

														<div class="form-group row">
																<label for="estatus" class="col-md-4 col-form-label text-md-right" hidden>{{ __('Estatus') }}</label>
																<div class="col-md-6">
																		<input type="number" class="form-control" name="estatus" value="{{ 1 }}" hidden required>
																</div>
														</div>
														<div class="form-group row">
																<div class="col-md-6 offset-md-4">
																		<button type="button" id="aceptar" class="btn btn-outline-primary">Aceptar</button>
																		<a href="{{ route('home') }}" class="btn btn-outline-secondary">Cancelar</a>
																</div>
														</div>
														<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																<div class="modal-dialog" role="document">
																		<div class="modal-content">
																				<div class="modal-header">
																						<h5 class="modal-title"  id="exampleModalLabel">Alta Sucursal</h5>
																						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																								<span aria-hidden="true">&times;</span>
																						</button>
																				</div>
																				<div class="modal-body">
																						<p class="card-text">¿Desea registrar la sucursal?</p>
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
										<p class="text-center">Usted no cuenta con los privilegios para estar aquí.</p>
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
				var nombre_sucursal = $("#nombre_sucursal").val();
				var direccion = $("#direccion").val();
				var telefono = $("#telefono").val();
				if(nombre_sucursal == '' && direccion == '' && telefono == ''){
					$('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Los campos están vacíos.</div>');
				}else if (nombre_sucursal != '' && direccion == '' && telefono != '') {
					$('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>La dirección de sucursal está vacía.</div>');
				}else if (nombre_sucursal == '' && direccion != '' && telefono != '') {
					$('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>El nombre de sucursal está vacío.</div>');
				}else if (nombre_sucursal != '' && direccion != '' && telefono == '') {
					$('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>El telefono de la sucursal está vacío.</div>');
				}else if(nombre_sucursal != '' && direccion == '' && telefono == ''){
					$('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Hay campos vacíos.</div>');
				}else if(nombre_sucursal == '' && direccion != '' && telefono == ''){
					$('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Hay campos vacíos.</div>');
				}else if(nombre_sucursal == '' && direccion == '' && telefono != ''){
					$('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Hay campos vacíos.</div>');
				}else{
					$("#myModal").modal();
				}
			}
		});
	</script>
@endsection
