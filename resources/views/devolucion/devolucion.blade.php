@extends('layouts.app')

@section('content')
    <div class="container center">
        <div class="card">
            <div class="card-header">
                Devolución
            </div>
            <div class="card-body">
                <div class="row" id="msg">

                </div>
                <form class="form-control" action="#" method="post">
                    <div class="row">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="id_venta"># de Venta: </label>
                                <input type="text" class="form-control" id="id_venta" name="id_venta" onkeyup="" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tipo_dev">Tipo de devolución</label>
                                <select class="form-control" id="tipo_dev" name="tipo_dev">
                                    <option value="">Selecciona tipo de devolución</option>
                                    <option value="cambio">Cambio</option>
                                    <option value="devol">Devolución</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="button" style="color:white">Devolución: </label>
                                <button type="button" class="btn btn-outline-primary" onclick="devolucion()" name="button">Realizar Devolución</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="Modal_dev" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table>
                                    <tr>
                                        <td id="venta">
                                        </td>
                                        <td></td>
                                        <td>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                ...
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <table>
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Descripción</th>
                                    <th>Importe</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="info">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function show(id) {
            $.ajax({
                async: true,
                type: 'get',
                url: '/devolucion/'+id,
                data: {'id':id},
                success:function(data){
                    $('#info').html(data);
                }
            });
        }
    </script>
    <script>
        $('#id_venta').on('keyup', function(){
            var id = $(this).val();
            console.log(id);
            if (id!="") {
                show(id);
            }
        });
    </script>
    <script>
        function devolucion() {
            var venta = $('#id_venta').val();
            var tipo = $('#tipo_dev').val();
            if (venta != "") {
                if (tipo != "") {
                    $('#Modal_dev').modal('show');
                    $.ajax({
                      type: 'get',
                      url: '/devolucion/create',
                      data: {'venta':venta, 'tipo':tipo},
                      success:function(data){
                          $('#venta').html(data);
                          console.log('cambio realizado');
                      }
                    });
                } else {
                    $('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>No se ha seleccionado el tipo de devolución</div>');
                }
            } else {
                $('#msg').html('<div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>No se ha ingresado un folio de venta</div>');
            }
        }
    </script>
    <script type="text/javascript">
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
    </script>
@endsection
