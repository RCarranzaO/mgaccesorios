@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<br/>
		<h3 align="center">Agregar Informacion</h3>
		<br/>
		@if(count($errors)>0)
		<div class="alert alert-danger">
			<ul>
			@foreach($errors->all as $error)
				<li>{{$error}}</li>
			@endforeach
		</ul>
		</div>
		@endif
		@if(\Session::has('success'))
		<div class="alert alert-success">
			<p>{{\Session::get('success')}}</p>
		</div>
		@endif

		<form method="post" action="{{url('producto')}}">
			{{csrf_field()}}
			<div class="form-group">
				<input type="varchar" name="referencia" class="form-control" placeholder="Referencia"/>
			</div>
			<div class="form-group">
				<input type="varchar" name="categoria_producto" class="form-control" placeholder="Categoria"/>
			</div>
			<div class="form-group">
				<input type="varchar" name="tipo" class="form-control" placeholder="Tipo de Producto"/>
			</div>
			<div class="form-group">
				<input type="text" name="marca" class="form-control" placeholder="Marca"/>
			</div>
			<div class="form-group">
				<input type="varchar" name="modelo" class="form-control" placeholder="Modelo"/>
			</div>
			<div class="form-group">
				<input type="varchar" name="color" class="form-control" placeholder="Color"/>
			</div>
			<div class="form-group">
				<input type="decimal" name="precio_compra" class="form-control" placeholder="Precio de Compra"/>
			</div>
			<div class="form-group">
				<input type="decimal" name="precio_venta" class="form-control" placeholder="Precio de Venta"/>
			</div>
			<div class="form-group">
				<input type="int" name="estatus" class="form-control" placeholder="Estatus" value="{{ 1 }}" hidden/>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary"/>
			</div>
	</div>
</div>

@endsection
