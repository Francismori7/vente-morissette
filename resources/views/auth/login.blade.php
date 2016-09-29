@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="container">
        <h1 class="page-header">Connexion</h1>

        <div class="row">
            <div class="col-xs-12 col-md-4 push-md-8">
                <div class="card">
                    <div class="card-header">Créer un compte</div>
                    <div class="card-block">
                        <a href="{{ url('/register') }}" class="btn btn-info btn-block">
                            Créer un compte
                        </a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Réseaux sociaux</div>
                    <div class="card-block">
                        <a href="{{ url('/login/facebook') }}" class="btn btn-primary btn-block">
                            <span class="fa fa-facebook"></span> Facebook
                        </a>
                        <a href="{{ url('/login/google') }}" class="btn btn-danger btn-block">
                            <span class="fa fa-google"></span> Google
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-8 pull-md-4">
                <div class="card">
                    <div class="card-header">Se connecter</div>
                    <div class="card-block">
                        <p class="text-muted">Si vous avez créé un compte, utilisez les mêmes informations pour vous
                            connecter à votre compte.</p>
                        <form role="form" method="POST" action="{{ url('/login') }}">
                            {!! csrf_field() !!}

                            <div class="row form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label class="col-xs-12 col-md-3 col-form-label">E-mail</label>

                                <div class="col-xs-12 col-md-9">
                                    <input type="email"
                                           class="form-control {{ $errors->has('email') ? 'form-control-danger' : '' }}"
                                           name="email"
                                           value="{{ old('email') }}" placeholder="E-mail">

                                    @if ($errors->has('email'))
                                        <small class="form-control-feedback">
                                            {{ $errors->first('email') }}
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <label class="col-xs-12 col-md-3 col-form-label">Mot de passe</label>

                                <div class="col-xs-12 col-md-9">
                                    <input type="password"
                                           class="form-control {{ $errors->has('password') ? 'form-control-danger' : '' }}"
                                           name="password"
                                           placeholder="Mot de passe">

                                    @if ($errors->has('password'))
                                        <small class="form-control-feedback">
                                            {{ $errors->first('password') }}
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-xs-12 col-md-9 offset-md-3">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="remember">
                                            Me garder connecté
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-xs-12 col-md-9 offset-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="fa fa-sign-in"></span> Se connecter
                                    </button>

                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Mot de passe oublié?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
