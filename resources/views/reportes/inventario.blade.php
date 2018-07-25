@extends('layouts.app')
@section('content')
    <script src="{{ asset('js/jquery/jquery-3.3.1.min.js') }}"></script>
        <div class="container">
            @include('alerts.success')
            <nav class="navbar navbar-ligth bg-ligth justify-content-left ">
                <form class="form-inline" action="#" method="get">
                    <input type="text" id="buscar" class="form-control mr-sm-2" name="buscar" placeholder="Buscar">
                    @if (Auth::user()->rol == 1)
                        <select id="buscador" class="form-control mr-sm-2" name="buscador">
                            <option value="0">{{ 'Seleccionar sucursal' }}</option>
                            @foreach ($sucursales as $sucursal)
                                @if ($sucursal->estatus != 0)
                                    <option value="{{$sucursal->id_sucursal}}">{{$sucursal->nombre_sucursal}}</option>
                                @endif
                            @endforeach
                        </select>
                        <button id="btnpdf" onclick="pdf()" type="button" class="btn btn-outline-primary">{{ 'Descargar productos en PDF' }}</button>
                    @else
                        <select id="buscador" class="form-control mr-sm-2" name="buscador">
                            @foreach ($sucursales as $sucursal)
                                @if ($sucursal->estatus != 0)
                                    @if($sucursal->id_sucursal != Auth::user()->id_sucursal)
                                    @else
                                        <option value="{{ Auth::user()->id_sucursal }}">{{$sucursal->nombre_sucursal}}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    @endif
                </form>
            </nav>

            <div class="card">
                <div class="card-header background-light">
                    <h4 class="card-title">{{ 'Listado de productos' }}</h4>
                </div>
                <div class="card-body">
                    <table id="myTable" class="table text-center table-responsive-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" onclick="ordenar(0)">{{ 'Referencia' }} <i class="fa fa-angle-up"></i> <i class="fa fa-angle-down"></i></th>
                                <th scope="col" onclick="ordenar(1)">{{ 'Categoría' }} <i class="fa fa-angle-up"></i> <i class="fa fa-angle-down"></i></th>
                                <th scope="col" onclick="ordenar(2)">{{ 'Tipo' }} <i class="fa fa-angle-up"></i> <i class="fa fa-angle-down"></i></th>
                                <th scope="col" onclick="ordenar(3)">{{ 'Marca' }} <i class="fa fa-angle-up"></i> <i class="fa fa-angle-down"></i></th>
                                <th scope="col" onclick="ordenar(4)">{{ 'Modelo' }} <i class="fa fa-angle-up"></i> <i class="fa fa-angle-down"></i></th>
                                <th scope="col" onclick="ordenar(5)">{{ 'Color' }} <i class="fa fa-angle-up"></i> <i class="fa fa-angle-down"></i></th>
                                <th scope="col" class="text-left">{{ 'Sucursal' }}</th>
                                <th scope="col">{{ 'Existencia' }}</th>
                                <th scope="col" class="text-right">{{ 'Precio' }}</th>
                                <th scope="col" class="text-right">{{ 'Total' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($productos->count())
                                @foreach ($productos as $producto)
                                    @if($producto->estatus != 0)
                                        <tr>
                                          <td>{{ $producto->referencia }}</td>
                                          <td>{{ $producto->categoria_producto }}</td>
                                          <td>{{ $producto->tipo_producto }}</td>
                                          <td>{{ $producto->marca }}</td>
                                          <td>{{ $producto->modelo }}</td>
                                          <td>{{ $producto->color }}</td>
                                          <td class="text-left">{{ $producto->nombre_sucursal }}</td>
                                          <td>{{ $producto->existencia }}</td>
                                          <td class="text-right">$ {{ number_format($producto->precio_venta, 2) }}</td>
                                          <td class="text-right">$ {{ number_format($producto->precio_venta*$producto->existencia, 2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10"><h3>{{ 'No se encuentran registros en la base de datos.' }}</h3></td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                    <hr>
                    {{ $productos->links() }}
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
            $('#buscador').click(function(){
                buscar();
            });
            
        });
        function buscar(){
            var $buscador=$("#buscador").val();
            var $buscar=$("#buscar").val();
            $.ajax({
                type: 'get',
                url: '{{ route('buscarR') }}',
                data: {'buscar':$buscar, 'buscador':$buscador},
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
    <script>
        function pdf(){
            var buscador=$("#buscador").val();
            var buscar=$("#buscar").val();
            $.ajax({
                type: 'get',
                url: '{{ route('almacen.pdf') }}',
                data: {'buscar':buscar, 'buscador':buscador},
                success:function(data){

                }
            });
        }
    </script>
    <script type="text/javascript">
        $.ajaxSetup({headers: {'csrftoken' : '{{ csrf_token() }}'} });
    </script>
@endsection
