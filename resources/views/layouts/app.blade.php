<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MgAccesorios</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="css/style.css">
    <!--<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div class="m-b-md" id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel mr-auto">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    MgAccesorios
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav nav-link links">


                        @guest

                        @else
                            <li class="nav-item dropdown links" >
                                <a class="nav-link dropdown-toggle" id="navbarDropdowncajaLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Caja</a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdowncajaLink">
                                    <a class="dropdown-item" href="{{ route('fondo') }}">Fondo</a>
                                    <a class="dropdown-item" href="{{ route('gasto') }}">Egreso</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown links">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown">Entradas</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('almacen.create') }}">Compras</a>
                                    <a class="dropdown-item" href="#">Devoluciones</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown links">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown">Salidas</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Ventas</a>
                                    <a class="dropdown-item" href="#">Traspaso a Sucursal</a>
                                    <a class="dropdown-item" href="#">Salida especial</a>
                                </div>
                            </li>
                            <li class="nav-item  links">
                                <a class="nav-link " href="{{ route('almacen.index') }}">Inventario</a>
                                <!--<div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Ventas</a>
                                    <a class="dropdown-item" href="#">Traspaso a Sucursal</a>
                                    <a class="dropdown-item" href="#">Salida especial</a>
                                </div>-->
                            </li>
                            @if (Auth::user()->rol == 1)
                                <li class="nav-item dropdown links">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">Productos</a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('producto.create') }}">Alta Producto</a>
                                        <a class="dropdown-item" href="{{ route('producto.index') }}">Modificar Porducto</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown links">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">Usuarios</a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('usuario.create') }}">Alta Usuario</a>
                                        <a class="dropdown-item" href="{{ route('usuario.index') }}">Modificar Usuario</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown links">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">Sucursal</a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('sucursal.create') }}">Alta Sucursal</a>
                                        <a class="dropdown-item" href="{{ route('sucursal.index') }}">Baja Sucursal</a>
                                    </div>
                                </li>
                            @endif
                            <li class="nav-item dropdown links">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown">Reportes</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Venta</a>
                                    <a class="dropdown-item" href="{{ route('repalmacen') }}">Inventario</a>
                                </div>
                            </li>
                            <li class="nav-item  links">
                                <a class="nav-link " href="{{ route('saldo') }}">Saldo</a>
                            </li>
                        @endguest
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <!--<li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>-->
                        @else

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4 m-b-md">
            @yield('content')
        </main>
        </div>
    </div>
</body>
</html>
