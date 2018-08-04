@extends('layouts.app')

@section('content')

@if (Auth::user()->rol == 1)
		<div class="container">
				@include('alerts.success')
				{{ $categorias->links() }}
				<table class="table text-center table-responsive-sm">
						<thead class="thead-dark">
								<tr>
										<th scope="col">ID</th>
										<th scope="col">Categoría</th>
										<th scope="col">Estatus</th>
										<th scope="col">Editar</th>
										<th scope="col">Cambiar estatus</th>
								</tr>
						</thead>
						<tbody>
								@foreach($categorias as $categoria)
										<tr>
												<td>{{ $categoria->id_categoria }}</td>
												<td>{{ $categoria->nombrec }}</td>
												<td>
														@if($categoria->estatus == 1)
																{{ $rol = 'Activo' }}
														@else
																{{ $rol = 'Inactivo' }}
														@endif
												</td>
												<td>
														<a href="{{ route('categorias.edit', $categoria->id_categoria) }}" class="btn btn-outline-info"><i class="fa fa-edit"></i> Editar</a>
												</td>
												<td>
														<form  method="post" action="/categorias/{{ $categoria->id_categoria }}">
																@csrf
																@method('DELETE')

																<button type="button" class="{{ $categoria->estatus==1 ? 'btn btn-outline-danger' : 'btn btn-outline-success' }}" data-toggle="modal" data-target="#ModalDelete{{$categoria->id_categoria}}">{{ $categoria->estatus == 1 ? _('Baja') : _('Alta') }}</button>
																<div class="modal fade" id="ModalDelete{{$categoria->id_categoria}}" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																				<div class="modal-content">
																						<div class="modal-header">
																								<h5 class="modal-title" id="ModalLabel">¡Alerta!</h5>
																								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																										<span aria-hidden="true">&times;</span>
																								</button>
																						</div>
																						<div class="modal-body">
																								<h3>{{ $categoria->estatus==1 ? '¿Desea dar de baja la categoria?' : '¿Desea dar de alta la categoria?' }}</h3>
																						</div>
																						<div class="modal-footer">
																										<!--<a class="btn btn-outline-primary" href="">Aceptar</button>-->
																										<button type="submit" class="btn btn-outline-primary">Aceptar</button>
																										<button type='button' class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
																						</div>
																				</div>
																		</div>
																</div>
														</form>
												</td>
										</tr>
								@endforeach
						</tbody>
				</table>
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
