<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rocket System V.0.1 @yield('title')</title>
        <!-- Favicon -->
        <link  rel="icon"   href="{{ asset('kharma.png') }}" type="image/favicon" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
        <!-- Bootstrap core CSS -->
        <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
        <!-- Material Design Bootstrap -->
        <link href="{{ asset('css/mdb.min.css')}}" rel="stylesheet">
        <!-- Your custom styles (optional) -->
        <link href="{{ asset('css/style.min.css')}}" rel="stylesheet">
        <!-- SCRIPTS -->
        <!-- JQuery -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

        <!-- SweetAlert -->
        <script src="{{ asset('assets/sweetalert2/dist/sweetalert2.min.js') }}"></script>
        <link rel="stylesheet" href="{{ 'assets/sweetalert2/dist/sweetalert2.min.css' }}">

        <style>

            .map-container{
                overflow:hidden;
                padding-bottom:56.25%;
                position:relative;
                height:0;
            }
            .map-container iframe{
                left:0;
                top:0;
                height:100%;
                width:100%;
                position:absolute;
            }
        </style>
    </head>

    <body class="grey lighten-3">

        @section('sidebar')
        <!--Main Navigation-->
        <header>

            <!-- Navbar -->
            <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">

                <div class="container-fluid">

                <a href="{{ url('/home') }}" class="navbar-brand waves-effect">
                        <strong class="blue-text">Dashboard</strong>
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <ul class="navbar-nav mr-auto">
                        </ul>

                        <!-- Right -->
                        <ul class="navbar-nav nav-flex-icons">
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('/mi-cuenta')}}">
                                        <i class="fa fa-address-card"> </i> Mi cuenta
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        <i class="fa fa-trash"> </i> Salir
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        </ul>

                    </div>

                </div>
            </nav>
            <!-- Navbar -->

            <!-- Sidebar -->
            <div class="sidebar-fixed position-fixed">

                <a href="{{ url('/home') }}" class="logo-wrapper waves-effect">
                    <img src="{{ asset('logotipo.png') }}" class="img-fluid" alt="">
                </a>

                <div class="list-group list-group-flush">

                <a href="{{ url('/home') }}" class="list-group-item list-group-item-action waves-effect bg bg-info">
                    <i class="fas fa-tachometer-alt mr-3"></i>Panel de control
                </a>

                <a href="{{ url('/empresa') }}" class="list-group-item list-group-item-action waves-effect">
                    <i class="far fa-id-card mr-3"></i>Empresa y usuarios
                </a>

                <a href="{{ url('/producto') }}" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-boxes mr-3"></i>Productos
                </a>

                <a href="{{ url('/categoria') }}" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-clipboard-list mr-3"></i>Categorias
                </a>
                <a href="{{ url('/proveedor') }}" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-shipping-fast mr-3"></i>Proveedores
                </a>

                <a href="{{ url('/ventas')}}" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-money-bill-alt mr-3"></i>Ventas</a>
                </div>

            </div>

        </header>
        <!--Main Navigation-->
        @show

        <div>
            <main class="pt-5 mx-lg-5">
                <div class="container-fluid mt-5">
                    @yield('content')
                </div>
            </main>

        </div>

        <!--Footer-->
        <footer class="page-footer text-center font-small mt-4 wow fadeIn">

            <!--Copyright-->
            <div class="footer-copyright py-3">
                © 2020 Copyright:
                <a href="https:github.com/chelitodelgado" target="_blank"> by chelitodelgado </a>
            </div>
            <!--/.Copyright-->
        </footer>
        <!--/.Footer-->

        <!-- SCRIPTS -->
        <!-- JQuery -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>
        <!-- Initializations -->
        <script type="text/javascript">
            // Animations initialization
            new WOW().init();
        </script>

        <!-- Charts -->
        <script>
            // Line
            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
            type: 'line',
            data: {
            labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio"],
            datasets: [{
                label: 'Ventas totales por mes',
                data: [12000, 10000, 3000, 5000, 2000, 15000],
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 2
            }]
            },
            options: {
            scales: {
                    yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                    }]
                }
            }
            });

            //line
            var ctxL = document.getElementById("lineChart").getContext('2d');
            var myLineChart = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio"],
            datasets: [{
                label: "Primer año",
                backgroundColor: [
                    'rgba(105, 0, 132, .2)',
                ],
                borderColor: [
                    'rgba(200, 99, 132, .7)',
                ],
                borderWidth: 2,
                data: [10000, 4000, 4000, 1000, 8000, 2000, 9000]
                },
                {
                label: "Segundo año",
                backgroundColor: [
                    'rgba(0, 137, 132, .2)',
                ],
                borderColor: [
                    'rgba(0, 10, 130, .7)',
                ],
                data: [12000, 10000, 3000, 5000, 2000, 15000, 40000],
                }
            ]
            },
            options: {
            responsive: true
            }
            });


            //radar
            var ctxR = document.getElementById("radarChart").getContext('2d');
            var myRadarChart = new Chart(ctxR, {
            type: 'radar',
            data: {
            labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
            datasets: [{
                label: "My First dataset",
                data: [65, 59, 90, 81, 56, 55, 40],
                backgroundColor: [
                'rgba(105, 0, 132, .2)',
                ],
                borderColor: [
                'rgba(200, 99, 132, .7)',
                ],
                borderWidth: 2
            }, {
                label: "My Second dataset",
                data: [28, 48, 40, 19, 96, 27, 100],
                backgroundColor: [
                'rgba(0, 250, 220, .2)',
                ],
                borderColor: [
                'rgba(0, 213, 132, .7)',
                ],
                borderWidth: 2
            }]
            },
            options: {
            responsive: true
            }
            });

            //doughnut
            var ctxD = document.getElementById("doughnutChart").getContext('2d');
            var myLineChart = new Chart(ctxD, {
            type: 'doughnut',
            data: {
            labels: ["Red", "Green", "Yellow", "Grey", "Dark Grey"],
            datasets: [{
                data: [300, 50, 100, 40, 120],
                backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
            }]
            },
            options: {
            responsive: true
            }
            });

        </script>

    </body>

</html>
