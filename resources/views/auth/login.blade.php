@extends('master.login')

@section('title', 'Page Title')

@section('content')

        @yield('content')
        <div class="login">
            <h1>Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input id="email" type="email" 
                    class="form-control @error('email') 
                    is-invalid @enderror" name="email" 
                    value="{{ old('email') }}" 
                    required autocomplete="email" 
                    placeholder="E-mail" autofocus>
                @error('email')
                <span class="invalid-feedback text-danger" role="alert">
                    <small>Compruebe el campo email</small>
                </span>
                @enderror

                <input id="password" type="password" 
                    class="form-control @error('password') 
                    is-invalid @enderror" name="password" 
                    required autocomplete="current-password" 
                    placeholder="Contraseña">
                @error('password')
                <span class="invalid-feedback text-danger" role="alert">
                    <small>Compruebe el campo email</small>
                </span>
                @enderror
                
                {{-- <input class="check" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> --}}

                <button type="submit" class="btn btn-primary btn-block btn-large">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif

            </form>
        </div>
@endsection