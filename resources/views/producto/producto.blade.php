@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
        </tbody>
    </table>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection

<!--
<div class="row">
  	<div class="coll-md-12">
  		  <br/>
  		  <h3 align="center">Producto</h3>
  		  <br/>
  		  @if($message = Session::get('success'))
  		      <div class="alert alert-success">
  			         <p>{{$message}}</p>
  		      </div>
  		  @endif
    		<div align="right">

      		  <table class="table table-bordered">
      			     <tr>
            				<th>Refencia</th>
            				<th>Categoria</th>
            				<th>Tipo</th>
            				<th>Marca</th>
            				<th>Modelo</th>
            				<th>Color</th>
            				<th>Precio Compra</th>
            				<th>Precio Venta</th>
            				<th>Estatus</th>
            			</tr>
      			      @foreach($producto as $row)
      			      <tr>
              				<td>{{$row['referencia']}}</td>
              				<td>{{$row['categoria_producto']}}</td>
              				<td>{{$row['tipo_producto']}}</td>
              				<td>{{$row['marca']}}</td>
              				<td>{{$row['modelo']}}</td>
              				<td>{{$row['color']}}</td>
              				<td>{{$row['precio_compra']}}</td>
              				<td>{{$row['precio_venta']}}</td>
              				<td>{{$row['estatus']}}</td>
            			</tr>
      			      @endforeach
      		  </table>
    	 </div>
    </div>
</div>
-->
