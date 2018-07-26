@extends('layouts.app')
@section('content')
    <div class="container">
        <nav class="navbar navbar-ligth bg-ligth justify-content-left ">
            <form class="form-inline" action="#" method="get">
                <input type="text" id="buscar" class="form-control mr-sm-2" name="buscar" placeholder="Buscar producto">
                {{ $salidas->links() }}
            </form>
        </nav>
        <div class="card">
            <div class="card-body">
                <table id="myTable" class="table text-center table-responsive-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" onclick="ordenar(0)">{{ 'Referencia' }} <i class="fa fa-angle-up"></i> <i class="fa fa-angle-down"></i></th>
                            <th scope="col">{{ 'Existencia' }}</th>
                            <th scope="col" colspan="2">{{ 'Cantidad a retirar' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($salidas->count())
                            @foreach ($salidas as $salida)
                                <tr>
                                    <td>{{ $salida->referencia }}</td>
                                    <td>{{ $salida->existencia }}</td>
                                    <td>
                                        <a href="{{ route('salidasesp.show', $salida->id_producto) }}" class="btn btn-outline-info">{{ 'Retirar' }}</a>
                                    </td>
                                </tr>
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
                url: '{{ route('buscarS') }}',
                data: {'buscar':$buscar},
                success:function(data){
                    $('tbody').html(data);
                }
            });
        }
        function ordenar(n){
            var $table, $rows, $switching, $i, $x, $y, $shouldSwitch, $dir, $switchcount = 0;
            $table = document.getElementById("myTable");
            $switching = true;
            $dir = "asc";

            while($switching){
                $switching = false;
                $rows = $table.getElementsByTagName("TR");
                for ($i = 1; $i < ($rows.length - 1); $i++) {
                    $shouldSwitch = false;
                    $x = $rows[$i].getElementsByTagName("TD")[n];
                    $y = $rows[$i + 1].getElementsByTagName("TD")[n];

                    if ($dir == "asc") {
                        if ($x.innerHTML.toLowerCase() > $y.innerHTML.toLowerCase()) {
                            $shouldSwitch= true;
                            break;
                        }
                    }else if ($dir == "desc") {
                        if ($x.innerHTML.toLowerCase() < $y.innerHTML.toLowerCase()) {
                            $shouldSwitch = true;
                            break;
                        }
                    }
                }
                if ($shouldSwitch) {
                    $rows[$i].parentNode.insertBefore($rows[$i + 1], $rows[$i]);
                    $switching = true;
                    $switchcount ++;
                }else {
                    if ($switchcount == 0 && $dir == "asc") {
                        $dir = "desc";
                        $switching = true;
                    }
                }
            }
        }
    </script>
    <script type="text/javascript">
        $.ajaxSetup({headers: {'csrftoken' : '{{ csrf_token() }}'} });
    </script>
@endsection
