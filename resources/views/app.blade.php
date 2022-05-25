<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{env('APP_NAME')}}</title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700"/>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    <link href="{{ mix('css/nucleo-icons.css') }}" type="text/css" rel="stylesheet"/>
    <link href="{{ mix('css/nucleo-svg.css') }}" type="text/css" rel="stylesheet"/>
    <link href="{{ mix('css/material-dashboard.css') }}" type="text/css" rel="stylesheet"/>
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-200">
@if (Auth::check())
    <script>
        window.Laravel = {!!json_encode([
            'isLoggedIn' => true,
            'user' => Auth::user()
        ])!!}
    </script>
@else
    <script>
        window.Laravel = {!!json_encode([
            'isLoggedIn' => false
        ])!!}
    </script>
@endif
<div id="app" class="g-sidenav-show">
</div>
<script src="{{ mix('js/main.js') }}" type="text/javascript"></script>
<script src="{{ mix('js/material-dashboard.js') }}" type="text/javascript"></script>
</body>
</html>
