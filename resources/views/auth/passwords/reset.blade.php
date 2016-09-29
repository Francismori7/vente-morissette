@extends('layouts.app')

@section('title', 'Réinitialiser mon mot de passe')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Réinitialiser mon mot de passe</div>

                <div class="card-block">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {!! csrf_field() !!}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label class="col-xs-12 col-md-3 col-form-label">E-Mail</label>

                            <div class="col-xs-12 col-md-9">
                                <p class="form-control-static">{{ $email }}</p>
                                <input type="hidden" name="email" value="{{ $email }}">
                            </div>
                        </div>

                        <div class="row form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label class="col-xs-12 col-md-3 col-form-label">Mot de passe</label>

                            <div class="col-xs-12 col-md-9">
                                <input type="password"
                                       class="form-control{{ $errors->has('password') ? ' form-control-danger' : '' }}"
                                       name="password" placeholder="Mot de passe">

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
                                    <span class="fa fa-btn fa-refresh"></span> Réinitialiser mon mot de passe
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
