@extends('layouts.app')

@section('content')

@if (Auth::user()->rol == 1)
		<div class="container">
				@include('alerts.success')
				<table class="table text-center">
						<thead class="thead-dark">
								<tr>
										<th scope="col">ID</th>
										<th scope="col">Nombre</th>
										<th scope="col">Apellido</th>
										<th scope="col">Usuario</th>
										<th scope="col">Correo</th>
										<th scope="col">Rol</th>
										<th scope="col">Sucursal</th>
										<th scope="col">Estatus</th>
										<th scope="col">Editar</th>
										<th scope="col">Cambiar estatus</th>
								</tr>
						</thead>
						<tbody>
								@foreach($usuarios as $usuario)
										<tr>
												<td>{{ $usuario->id_user }}</td>
												<td>{{ $usuario->name }}</td>
												<td>{{ $usuario->lastname }}</td>
												<td>{{ $usuario->username }}</td>
												<td>{{ $usuario->email }}</td>
												<td>
														@if($usuario->rol == 1)
																{{ $rol = 'Administrador' }}
														@else
																{{ $rol = 'Vendedor' }}
														@endif
												</td>
												<td>{{ $usuario->id_sucursal }}</td>
												<td>
														@if($usuario->estatus == 1)
																{{ $rol = 'Activo' }}
														@else
																{{ $rol = 'Inactivo' }}
														@endif
												</td>
												<td>
														<a href="{{ route('usuario.edit', $usuario->id_user) }}" class="btn btn-outline-info">Editar</a>
												</td>
												<td>
														<form  method="post" action="/usuario/{{ $usuario->id_user }}">
																@csrf
																@method('DELETE')

																<button type="button" class="{{ $usuario->estatus==1 ? 'btn btn-outline-danger' : 'btn btn-outline-success' }}" data-toggle="modal" data-target="#ModalDelete{{$usuario->id_user}}">{{ $usuario->estatus == 1 ? _('Baja') : _('Alta') }}</button>
																<div class="modal fade" id="ModalDelete{{$usuario->id_user}}" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																				<div class="modal-content">
																						<div class="modal-header">
																								<h5 class="modal-title" id="ModalLabel">Alerta!</h5>
																								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																										<span aria-hidden="true">&times;</span>
																								</button>
																						</div>
																						<div class="modal-body">
																								<h3>{{ $usuario->estatus==1 ? 'Desea dar de baja el usuario?' : 'Desea dar de alta el usuario?' }}</h3>
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
