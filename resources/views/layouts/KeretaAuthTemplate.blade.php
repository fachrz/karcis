<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('pageTitle')</title>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark krc-navbar-wrapper">
        <a class="navbar-brand" href="{{ asset('/kereta') }}">
            <img src="{{ asset('images/ticket.svg') }}" alt="logo" style="width:40px;">
            <b>Karcis</b>.com
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                @if (Session::get('status') != 1)
                <li class="nav-item">
                    <a class="nav-link krc-login-button" href="{{ url('/login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link krc-register-button" href="{{ url('/register') }}">Register</a>
                </li>
                @elseif (Session::get('status') == 1)
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ Session::get('first_name') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/logout') }}">Logout</a>
                </li>
                @endif
            </ul>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScript Library -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/kereta_app.js') }}"></script>
    <script src="{{ asset('js/style.js') }}"></script>
    @yield('jslib')

</body>

</html>