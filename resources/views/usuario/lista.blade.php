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
				<th scope="col">Editar</th>
			</tr>
		</thead>

		<tbody>
			
			@foreach($usuarios as $usuario)
				@if($usuario->estatus==1)
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
							<a href="{{ action('UsuarioController@edit', $usuario->id_user) }}" class="btn btn-outline-info">Editar</a>
						</td>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
</div>

@endsection

<!--
	route('usuario.edit') }}
-->