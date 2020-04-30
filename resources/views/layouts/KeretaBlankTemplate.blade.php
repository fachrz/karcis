<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstraps/css/bootstrap.min.css') }} ">
    @yield('csslib')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('pageTitle')</title>

</head>

<body>

    @yield('content')
    <!-- JavaScript Library -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/kereta_app.js') }}"></script>
    <script src="{{ asset('js/style.js') }}"></script>
    @yield('jslib')
</body>

</html>