<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Chrome, Firefox OS, Opera and Vivaldi -->
    <meta name="theme-color" content="#2cb75f">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#2cb75f">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#2cb75f">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel =;;;;;;;;;;;;;;;;;; <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body id="app" :user="{{ auth()->user() }}" class="m-b-3">
    <nav class="navbar navbar-full navbar-dark m-b-2 bg-success">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler hidden-md-up pull-xs-right" type="button" data-toggle="collapse"
                    data-target="#collapsenav">
                &#9776;
            </button>
            <div class="collapse navbar-toggleable-sm pull-xs-left pull-md-none" id="collapsenav">
                <ul class="nav navbar-nav">
                    <li class="nav-item pull-xs-none pull-md-left">
                        <a class="nav-link" href="{{ url('/') }}">Accueil</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav pull-xs-right">
                    <!-- Authentication Links -->
                    @if (!auth()->user())
                        <li class="nav-item pull-xs-none pull-md-left">
                            <a class="nav-link" href="{{ url('/login') }}">Connexion</a>
                        </li>
                        <li class="nav-item pull-xs-none pull-md-left">
                            <a class="nav-link" href="{{ url('/register') }}">S'enregistrer</a>
                        </li>
                    @else
                        <li class="dropdown nav-item pull-xs-none pull-md-left">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                                     class="img-avatar img-avatar-navbar">
                                {{ auth()->user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <a class="dropdown-item" href="/dashboard">
                                    <span class="fa fa-user fa-fw"></span>
                                    Panneau de contrôle
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ url('/logout') }}"
                                   class="dropdown-item"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="fa fa-sign-out"></span>
                                    Déconnexion
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div v-cloak>
        @yield('content')
    </div>

    <footer class="navbar navbar-fixed-bottom navbar-dark bg-inverse">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-xs-center text-muted small">
                    Copyright &copy; Mori7 Technologie inc.
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.2/js/tether.min.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>