<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - Autorisation</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <style>
        .passport-authorize .container {
            margin-top: 30px;
        }

        .passport-authorize .scopes {
            margin-top: 20px;
        }

        .passport-authorize .buttons {
            margin-top: 25px;
            text-align: center;
        }

        .passport-authorize .btn {
            width: 125px;
        }

        .passport-authorize .btn-approve {
            margin-right: 15px;
        }

        .passport-authorize form {
            display: inline;
        }
    </style>
</head>
<body class="passport-authorize">
    <div class="container">
        <h1>Morissette</h1>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card card-default">
                    <div class="card-header">
                        Demande d'autorisation
                    </div>
                    <div class="card-block">
                        <!-- Introduction -->
                        <p><strong>{{ $client->name }}</strong> demande la permission d'accéder à votre compte.</p>

                        <!-- Scope List -->
                        @if (count($scopes) > 0)
                            <div class="scopes">
                                    <p><strong>Cette application pourra:</strong></p>

                                    <ul>
                                        @foreach ($scopes as $scope)
                                            <li>{{ $scope->description }}</li>
                                        @endforeach
                                    </ul>
                            </div>
                        @endif

                        <div class="buttons">
                            <!-- Authorize Button -->
                            <form method="post" action="/oauth/authorize">
                                {{ csrf_field() }}

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <button type="submit" class="btn btn-success btn-approve">Autoriser</button>
                            </form>

                            <!-- Cancel Button -->
                            <form method="post" action="/oauth/authorize">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <button class="btn btn-danger">Refuser</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
