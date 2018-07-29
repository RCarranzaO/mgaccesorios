@extends('layouts.app')
@section('content')
    <div class="container">
        <nav class="navbar navbar-ligth bg-ligth justify-content-left ">
            <form class="form-inline" action="#" method="get">
                <input type="text" id="buscar" class="form-control mr-sm-2" name="buscar" placeholder="Buscar producto">
                {{ $traspasos->links() }}
            </form>
        </nav>
        <div class="card">
            <div class="card-body">
                <table id="myTable" class="table text-center table-responsive-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">{{ 'Referencia' }}</th>
                            <th scope="col">{{ 'Producto' }}</th>
                            <th scope="col">{{ 'Existencia' }}</th>
                            <th scope="col" colspan="2">{{ 'Cantidad a retirar' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($traspasos->count())
                            @foreach ($traspasos as $traspaso)
                                @if ($traspaso->estatus == 1)
                                    <tr>
                                        <td>{{ $traspaso->referencia }}</td>
                                        <td>{{ $traspaso->categoria_producto }}, {{ $traspaso->tipo_producto }}, {{ $traspaso->marca }}, {{ $traspaso->modelo }}, {{ $traspaso->color }}</td>
                                        <td>{{ $traspaso->existencia }}</td>
                                        <td>
                                            <a href="{{ route('traspaso.show', $traspaso->id_producto) }}" class="btn btn-outline-info">{{ 'Traspasar' }}</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8"><h3>{{ 'No se encuentran registros de productos.' }}</h3></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
                url: '{{ route('buscarT') }}',
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
