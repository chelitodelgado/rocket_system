<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rocket System V.0.1 @yield('title')</title>
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        <link href="{{ asset('css/mdb.min.css')}}" rel="stylesheet">
        <!-- SweetAlert -->
        <script src="{{ asset('assets/sweetalert2/dist/sweetalert2.min.js') }}"></script>
        <link rel="stylesheet" href="{{ 'assets/sweetalert2/dist/sweetalert2.min.css' }}">
</head>
<body>

    <div>
        <main class="pt-5 mx-lg-5">
            <div class="container-fluid mt-5">
                @yield('content')
            </div>
        </main>

    </div>

</body>
</html>
