@extends('layouts.app')
@section('content')
  @if (Auth::user()->rol == 1)
      <div class="container">
          @include('alerts.success')
          <nav class="navbar navbar-ligth bg-ligth justify-content-left ">
            <form class="form-inline" action="#" method="get">
              <input type="text" id="buscar" class="form-control mr-sm-2" name="buscar" placeholder="Buscar producto">
            </form>
          </nav>
          <table class="table text-center table-responsive-sm">
              <thead class="thead-dark">
                  <tr>
                      <th scope="col">Refencia</th>
                      <th scope="col">Categoria</th>
                      <th scope="col">Tipo</th>
                      <th scope="col">Marca</th>
                      <th scope="col">Modelo</th>
                      <th scope="col">Color</th>
                      <th scope="col">Precio Compra</th>
                      <th scope="col">Precio Venta</th>
                      <th scope="col">Estatus</th>
                      <th scope="col"></th>
                      <th scope="col"></th>
                  </tr>
              </thead>
              <tbody>
                  @if ($productos->count())
                      @foreach ($productos as $producto)
                          <tr>
                              <td>{{ $producto->referencia }}</td>
                              <td>{{ $producto->categoria_producto }}</td>
                              <td>{{ $producto->tipo_producto }}</td>
                              <td>{{ $producto->marca }}</td>
                              <td>{{ $producto->modelo }}</td>
                              <td>{{ $producto->color }}</td>
                              <td>$ {{ $producto->precio_compra}}</td>
                              <td>$ {{ $producto->precio_venta }}</td>
                              <td>{{ $producto->estatus == 1 ? 'Activo' : 'Inactivo' }}</td>
                              <td>
                                  <a href="{{ route('producto.edit', $producto->id_producto) }}" class="btn btn-outline-info">Editar</a>
                              </td>
                              <td>
                                  <form method="post" action="/producto/{{ $producto->id_producto }}" >
                                      @csrf
                                      @method('DELETE')
                                      <button type="button" class="{{ $producto->estatus==1 ? 'btn btn-outline-danger' : 'btn btn-outline-success' }}" data-toggle="modal" data-target="#ModalDelete{{$producto->id_producto}}">{{ $producto->estatus == 1 ? _('Baja') : _('Alta') }}</button>
                                      <div class="modal fade" id="ModalDelete{{$producto->id_producto}}" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="ModalLabel">Alerta!</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                  <div class="modal-body">
                                                      <h3>{{ $producto->estatus==1 ? 'Desea dar de baja el producto?' : 'Desea dar de alta el producto?' }}</h3>
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

                  @else
                      <tr>
                          <td colspan="11"><h3>{{ 'No hay registros de productos.' }}</h3></td>
                      </tr>
                  @endif

              </tbody>
          </table>
          <hr>
          <div class="row">
            <div class="col-ms-1">
              {{ $productos->links() }}
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
                      <h3>No tienes lo privilegios para entrar aquí!! Adios!</h3>
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
      $('#buscar').keyup(function(){
        buscar();
      });
    });
    function buscar(){
      var $buscar=$("#buscar").val();
      $.ajax({
        type: 'get',
        url: '{{ route('buscarP') }}',
        data: {'buscar':$buscar},
        success:function(data){
          $('tbody').html(data);
        }
      });
    }
  </script>
  <script type="text/javascript">
    $.ajaxSetup({headers: {'csrftoken' : '{{ csrf_token() }}'} });
  </script>
@endsection
