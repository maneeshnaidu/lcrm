<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
    <title>{{ trans('errors.not_found') }}</title>
    @include('layouts.header._meta')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/404.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
<div id="animate">
    <div class="text-white number text-center">
        {{ trans('errors.go_back_to') }}
        <a href="{{ url('/') }}" class="text-primary text-uppercase">{{ trans('frontend.home') }}</a>
    </div>
    <div class="text-center">
        <img src="{{ asset('img/404.png') }}" class="img-fluid center-block" alt="Page Not Found" />
    </div>
</div>
<script src="{{ asset(mix('js/libs.js')) }}" type="text/javascript"></script>
<script src="{{ asset('js/404.js') }}"></script>
</body>
</html>
