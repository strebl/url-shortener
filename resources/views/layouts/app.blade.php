<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <title>{{config('app.name')}}</title>

    <meta name="description" content="Simple and Responsive URL Shortener - Transform your long links to short link">

    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400" rel="stylesheet">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    @include('layouts.favicons')
</head>
<body>
<div class="flex-container">
    <div class="flex-item">
        <div class="site-header">
            <a class="site-header__link" href="/">{{config('app.name')}}</a>
            <div class="site-header__description">URL shortener</div>
        </div>
        @yield('content')
    </div>
</div>
<script src="{{ elixir('js/main.js') }}"></script>
{!! Analytics::render() !!}
</body>
</html>