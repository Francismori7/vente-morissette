@extends('layouts.app')

@section('title', "S'enregistrer")

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-4 push-md-7">
                <div class="card">
                    <div class="card-header">J'ai déjà un compte!</div>
                    <div class="card-block">
                        <a href="{{ url('/login') }}" class="btn btn-info btn-block">
                            Me connecter à mon compte
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 offset-md-1 pull-md-4">
                <div class="card">
                    <div class="card-header">Créer un compte</div>
                    <div class="card-block">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {!! csrf_field() !!}

                            <div class="row form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="col-xs-12 col-md-3 col-form-label">Nom</label>

                                <div class="col-xs-12 col-md-9">
                                    <input type="text"
                                           class="form-control{{ $errors->has('name') ? ' form-control-danger' : '' }}"
                                           name="name" value="{{ old('name') }}"
                                           placeholder="Votre nom">

                                    @if ($errors->has('name'))
                                        <small class="form-control-feedback">
                                            {{ $errors->first('name') }}
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label class="col-xs-12 col-md-3 col-form-label">E-Mail</label>

                                <div class="col-xs-12 col-md-9">
                                    <input type="email"
                                           class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}"
                                           name="email"
                                           value="{{ old('email') }}" placeholder="E-Mail">

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
                                           class="form-control{{ $errors->has('password') ? ' form-control-danger' : '' }}"
                                           name="password"
                                           placeholder="Mot de passe">

                                    @if ($errors->has('password'))
                                        <small class="form-control-feedback">
                                            {{ $errors->first('password') }}
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                <label class="col-xs-12 col-md-3 col-form-label"></label>

                                <div class="col-xs-12 col-md-9">
                                    <input type="password"
                                           class="form-control{{ $errors->has('password_confirmation') ? ' form-control-danger' : '' }}"
                                           name="password_confirmation"
                                           placeholder="Mot de passe (confirmation)">

                                    @if ($errors->has('password_confirmation'))
                                        <small class="form-control-feedback">
                                            {{ $errors->first('password_confirmation') }}
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-xs-12 col-md-9 offset-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="fa fa-user"></span> Créer mon compte
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
