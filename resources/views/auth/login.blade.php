@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row {{ $errors->has('username') ? 'has-error' : '' }}">
                            <label for="login" class="col-sm-4 col-form-label text-md-right">{{ __('Email o Usuario') }}</label>

                            <div class="col-md-6">
                                <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required autofocus placeholder="Introduce correo o usuario">

                                @if ($errors->has('login'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sucursal" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }}</label>

                            <div class="col-md-6">
                                <select class="form-control {{ $errors->has('sucursal') ? ' is-invalid' : '' }}" name="sucursal" required>
                                    <option> </option>
                                    <option value="1">Sucursal 1</option>
                                    <option value="2">Sucursal 2</option>
                                </select>
                                <!--<input id="rol" type="text" class="form-control{{ $errors->has('sucursal') ? ' is-invalid' : '' }}" name="rol" value="{{ old('rol') }}" required>-->

                                @if ($errors->has('sucursal'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('sucursal') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tu contraseña?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
