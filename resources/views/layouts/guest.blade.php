<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app2.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app2.js') }}"></script>
    <style type="text/css">
        .main-wrapper {
            background-image: url('/assets/img/bg-login.jpg');
            background-position: bottom;
            background-size: cover;
        }
    </style>
</head>

<body>
    {{ $slot }}
</body>

</html>