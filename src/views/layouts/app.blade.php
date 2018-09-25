<?php
if( isset($_SERVER['REQUEST_URI']) ) {
    $containsCrons = strpos($_SERVER['REQUEST_URI'], '/crons');
    $containsTasks = strpos($_SERVER['REQUEST_URI'], '/tasks');
    $containsSettings = strpos($_SERVER['REQUEST_URI'], '/settings');
} else {
    $containsCrons = true;
    $containsTasks = false;
    $containsSettings = false;
}
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @if (Route::has('login'))
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if (Session::has('stsp-type') )
                <div class="alert alert-{{ Session::get('stsp-status') }} alert-dismissible fade show">
                    <h4 class="alert-heading mb-0">{{ Session::get('stsp-message') }}</h4>
                    @if (Session::has('stsp-details') )
                        <hr />
                        <p class="mb-0">{{ Session::get('stsp-details') }}</p>
                    @endif
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-12 mb-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($containsTasks && !$containsCrons && !$containsSettings) ? 'active' : '' ?>" href="{{ route('tasks') }}">Tasks / Artisan Commands</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($containsCrons) ? 'active' : '' ?>" href="{{ route('crons') }}">Cron Expressions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($containsSettings || !$containsTasks && !$containsCrons && !$containsSettings) ? 'active' : '' ?>" href="{{ route('settings') }}">Settings</a>
                        </li>
                    </ul>
                </div>
                @yield('content')
            </div>
        </div>
    </main>
</div>
</body>
</html>
