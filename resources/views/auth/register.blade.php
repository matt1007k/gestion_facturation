@extends('layouts.auth')

@section('content')
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>Registrarse</h1>
                <p class="text-muted">Crea tu cuenta</p>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="icon-user"></i>
                            </span>
                        </div>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Michael Brown" name="name" value="{{ old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="user123@example.com" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
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
                            <span class="input-group-text">
                            <i class="icon-lock"></i>
                            </span>
                        </div>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="************" required>
                    </div>
                    <button class="btn btn-block btn-success" type="submit">Registrarse</button>
                </form>
            </div>
            <div class="card-footer p-4">
                <div class="row">
                    <div class="col-12 text-center">
                        Ya tengo una cuenta
                        <a class="btn btn-link px-0" href=" {{ route('login') }} ">
                            Ingresar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
