@extends('layouts.app')

@section('content')
  <div class="container">
			<div class="row justify-content-center">
					<div class="col-md-8">
							<div class="card">
									<div class="card-header"><h4>Dar alta un producto</h4></div>
									<div class="card-body">
											<form method="post" action="/producto/{{ $producto->id_producto }}">
													@csrf
                          <input type="hidden" name="_method" value="PATCH">

													<div class="form-group row">
															<label for="referencia" class="col-md-4 col-form-label text-md-right">Referencia</label>

															<div class="col-md-6">
																	<input id="referencia" type="text" class="form-control{{ $errors->has('referencia') ? ' is-invalid' : '' }}" name="referencia" value="{{ $producto->referencia }}" required>

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
																	<input id="categoria" type="text" class="form-control{{ $errors->has('categoria') ? ' is-invalid' : '' }}" name="categoria" value="{{ $producto->categoria_producto }}" required>

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
																	<input id="tipo" type="text" class="form-control{{ $errors->has('tipo') ? ' is-invalid' : '' }}" name="tipo" value="{{ $producto->tipo_producto }}" required>

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
																	<input id="marca" type="text" class="form-control{{ $errors->has('marca') ? ' is-invalid' : '' }}" name="marca" value="{{ $producto->marca }}" required>

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
																	<input id="modelo" type="text" class="form-control{{ $errors->has('modelo') ? ' is-invalid' : '' }}" name="modelo" value="{{ $producto->modelo }}" required>

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
																	<input id="color" type="text" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" name="color" value="{{ $producto->color }}" required>

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
																	<input id="precio_compra" type="text" class="form-control{{ $errors->has('precio_compra') ? ' is-invalid' : '' }}" name="precio_compra" value="{{ $producto->precio_compra }}" required>

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
																	<input id="precio_venta" type="text" class="form-control{{ $errors->has('precio_venta') ? ' is-invalid' : '' }}" name="precio_venta" value="{{ $producto->precio_venta }}" required>

																	@if($errors->has('precio_venta'))
																			<span class="invalid-feedback">
																					<strong>{{ $errors->first('precio_venta') }}</strong>
																			</span>
																	@endif

															</div>
													</div>

													<div class="form-group row">
															<div class="col-md-9 offset-md-3">

																	<button type="submit" class="btn btn-outline-primary" name="action" value="ays">Aceptar y salir</button>
                                  <button type="submit" class="btn btn-outline-primary" name="action" value="aym">Aceptar y modificar</button>
																	<a href="{{ route('home') }}" class="btn btn-outline-secondary">Cancelar</a>

															</div>
													</div>
											</form>
									</div>
							</div>
				  </div>
			</div>
	</div>
@endsection
