@extends('layouts.app')

@section('content')

@if (Auth::user()->rol == 1)
		<div class="container">
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
														<form method="post" action="/usuario/{{ $usuario->id_user }}">
																@csrf
																@method('DELETE')
																@if($usuario->estatus == 1)
																		<button class="btn btn-outline-danger" type="button" data-toggle="modal" data-target="#myModalu">Baja</button>
																@else
																		<button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#myModalu">Alta</button>
																@endif
																<div class="modal" id="myModalu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelu" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"  id="exampleModalLabelu">Usuarios</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="card-text">¿Desea dar de baja?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-outline-primary">Aceptar</button>
                                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
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
