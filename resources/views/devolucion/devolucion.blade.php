@extends('layouts.app')

@section('content')
    <div class="container center">
        <div class="card">
            <div class="card-header">
                Devolución
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="num_venta"># de Venta: </label>
                            <input type="text" class="form-control" id="venta" name="num_venta" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="button" style="color:white">Devolución: </label>
                            <button type="button" class="btn btn-outline-primary" name="button">Realizar Devolución</button>
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
        $('#venta').on('keyup', function(){
            var id=$(this).val();
            console.log(id);
            if (id!="") {
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
        });
    </script>
    <script>
        function cambiar(id) {
            $.ajax({
                type: 'get'
            })
        }
    </script>
    <script type="text/javascript">
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
    </script>
@endsection
