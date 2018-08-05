@extends('layouts.app')

@section('content')

@if (Auth::user()->rol == 1)
		<div class="container">
				<div class="row justify-content-center">
						<div class="col-md-8">
								<div class="card">
										<div class="card-header"><h4>{{ "Actualizar categoría" }}</h4></div>
										<div class="card-body">
												<form method="post" action="/categorias/{{ $categoria->id_categoria }}">
														@csrf
														<input type="hidden" name="_method" value="PATCH">

														<div class="form-group row">
																<label for="nombrec" class="col-md-4 col-form-label text-md-right">{{ "Nombre de categoría:" }}</label>
																<div class="col-md-6">
																		<input id="nombrec" type="text" class="form-control{{ $errors->has('nombrec') ? ' is-invalid' : '' }}" name="nombrec" value="{{ $categoria->nombrec }}" required>
																		@if($errors->has('nombrec'))
																				<span class="invalid-feedback">
																						<strong>{{ $errors->first('nombrec') }}</strong>
																				</span>
																		@endif
																</div>
														</div>

														<div class="form-group">
																<div class="col-md-8 offset-md-4">
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
