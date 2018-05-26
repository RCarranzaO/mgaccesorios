@extends('layouts.app')

@section('content')

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
				<th scope="col">Estatus</th>
				<th scope="col">Editar</th>
				<th scope="col">Dar de baja</th>
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
						<a href="{{ route('usuario.edit', $usuario->id_user) }}" class="btn btn-outline-danger">Baja</a>
					</td>
				</tr>


			@endforeach
		</tbody>
	</table>
</div>

@endsection
