@extends('layouts.app')
@section('content')
@if (Auth::user()->rol == 1)
		<div class="container">
				<div class="row justify-content-center">
						<div class="col-md-8">

								<div class="card">
										<div class="card-header"><h4>{{ "Alta de tipo de producto" }}</h4></div>
										<div class="card-body">
												<form class="form-control" method="post" action="{{ route('tipos.store') }}">
														@csrf
														@include('alerts.errores')
														<div id="msg" class="col-sm"></div>

														<div class="form-group row">
																<label for="nombret" class="col-md-4 col-form-label text-md-right">{{ "Nombre del tipo:" }}</label>
																<div class="col-md-6">
																		<input id="tipo" class="form-control {{ $errors->has('nombret') ? ' is-invalid' : '' }}" type="text" name="nombret" placeholder="Nombre" required>
																		@if($errors->has('nombret'))
																				<span class="help-block">
																						<strong>{{ $errors->first('nombret') }}</strong>
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
																						<h5 class="modal-title"  id="exampleModalLabel">{{ "Alta de Tipo" }}</h5>
																						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																								<span aria-hidden="true">&times;</span>
																						</button>
																				</div>
																				<div class="modal-body">
																						<p class="card-text">{{ "¿Desea registrar el tipo?" }}</p>
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
										<p class="text-center">{{ "Usted no cuenta con los privilegios para estar aquí." }}</p>
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
				var tipo = $("#tipo").val();
				if(tipo == ''){
					$('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>El nombre del tipo de producto está vacío.</div>');
				}else{
					$("#myModal").modal();
				}
			}
		});
	</script>
@endsection
