@extends('master.app')

@section('title',  '- Mi cuenta')

@section('sidebar')
    @parent

@endsection

@section('content')

        @yield('content')

        <div class="card testimonial-card">

            <!--Bacground color-->
            <div class="card-up indigo lighten-1">
            </div>

            <div class="card-body">
                @foreach ($user as $item)
                <!--Name-->
                <p class="text-danger"><small>Nombre:</small></p>
                <h4 class="card-title">{{ $item->name }}</h4>
                <hr>
                <!--Rol-->
                <p class="text-danger"><small>Puesto:</small></p>
                <h4 class="card-title">{{ $item->description }}</h4>
                <hr>
                <!--Email-->
                <p class="text-danger"><small>Email:</small></p>
                <h4 class="card-title">{{ $item->email }}</h4>
                <hr>
                @endforeach
            </div>

            <div class="card-footer bg bg-default">
                @foreach ($empresa as $nombre)
                <p class="card-title text-center">{{ $nombre->nombre }}</p>
                @endforeach
            </div>

        </div>


@endsection
