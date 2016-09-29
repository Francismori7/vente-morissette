@extends('layouts.app')

@section('title', 'Réinitialiser mon mot de passe')

<!-- Main Content -->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Réinitialiser mon mot de passe</div>
                    <div class="card-block">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p class="text-muted">
                            Si vous avez oublié votre mot de passe, entrez votre adresse courriel et
                            nous vous enverront un lien pour réinitialiser votre mot de passe.
                        </p>

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                            {!! csrf_field() !!}

                            <div class="row form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label class="col-xs-12 col-md-3 col-form-label">E-Mail</label>

                                <div class="col-xs-12 col-md-9">
                                    <input type="email"
                                           class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}"
                                           name="email" value="{{ old('email') }}"
                                           placeholder="E-Mail">

                                    @if ($errors->has('email'))
                                        <small class="form-control-feedback">
                                            {{ $errors->first('email') }}
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-xs-12 col-md-9 offset-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="fa fa-btn fa-envelope"></span> Envoyer un lien de réinitialisation
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
