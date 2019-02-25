@extends('layouts.auth')

@section('content')
    <div class="col-md-8">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    <h1>Iniciar sesion</h1>
                    <p class="text-muted">Ingresar a tu cuenta</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="icon-envelope-open"></i>
                                </span>
                            </div>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="user123@example.com" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="icon-lock"></i>
                                </span>
                            </div>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="************" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <input class="input-group-text" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            </div>

                            <label class="form-control" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <button class="btn btn-primary px-4" type="submit">Ingresar</button>
                            </div>
                            <div class="col-7 text-right">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                        {{ __('Olvidaste tu contraseña?') }}
                                    </a>
                                @endif                                    
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                <div class="card-body text-center">
                    <div>
                        <h2>Crear una cuenta</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <a class="btn btn-primary active mt-3" href="{{route('register')}} ">Registrase ahora!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
