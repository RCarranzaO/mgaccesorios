@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Generar venta</h1>
        <div class="card">
            <div class="card-header background-light">
                <h3 class="card-title">Nueva Venta</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <form class="form" action="" method="post">
                            <div class="card card-info">
                                <div class="card-header background-light">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 class="card-title">Detalles de la Venta</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-outline-success pull-right" name="button">Imprimir ticket</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-background">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                  <label for="sucursal">Sucursal</label>
                                                  @foreach ($sucursales as $sucursal)
                                                      @if ($sucursal->id_sucursal == $user->id_sucursal)
                                                          <input type="text" class="form-control" value="{{ $sucursal->nombre_sucursal }}" disabled>
                                                      @endif
                                                  @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="fecha">Fecha</label>
                                                  <input type="date" class="form-control" value="{{ $fecha = date('Y-m-d') }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group text-center">
                                                  <label for="venta">Venta N°</label>
                                                  <input type="text" class="form-control text-right" value="{{ empty($venta) ? 1 : $venta->id_venta+1 }}" disabled >
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                  <label for="buscar">Agregar productos</label>
                                                  <button type="button" class="btn btn-block btn-outline-info" name="button" data-toggle="modal" data-target="#ModalProd">Buscar Producto</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="ModalProd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                  <form class="form-horizontal" action="index.html" method="post">
                                      <div class="form-group">
                                          <div class="col-sm-6">
                                              <input type="text" id="search" class="form-control" name="" placeholder="Buscar productos" onkeyup="">
                                          </div>
                                          <button type="button" class="btn btn-outline-default">Buscar</button>
                                      </div>
                                  </form>
                              </div>
                              <div class="modal-footer">
                                ...
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
