@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="card-group w-75 mx-auto">

        <div class="card">
            <div class="card-header">{{ __('Já possuo uma conta') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">{{ __('Endereço de email') }}</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('Senha') }}</label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Lembrar-me') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group w-100">
                        <button type="submit" class="btn btn-primary w-100">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">{{ __('Criar conta') }}</div>
            <div class="card-body">
                <form method="GET" action="{{ route('register') }}">

                    <div class="form-group">
                        <label for="emailr">{{ __('Endereço de email') }}</label>
                        <input id="emailr" type="email" class="form-control{{ $errors->has('emailr') ? ' is-invalid' : '' }}" name="emailr" placeholder="Informe seu e-mail" required autofocus>
                        <small class="form-text text-muted">Nós nunca compartilharemos seu email com ninguém.</small>
                        @if ($errors->has('emailr'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('emailr') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group w-100">
                        <button type="submit" class="btn btn-primary w-100">
                            {{ __('Prosseguir') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
