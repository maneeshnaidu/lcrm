<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
    @include('layouts.frontend._meta')
    @include('layouts.frontend._header-assets')
    @yield('styles')
</head>
<body>
<div id="app">
    <header class="header">
        @include('layouts.frontend._header')
    </header>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-5">
                    @include('flash::message')
                </div>
            </div>
        </div>

        @yield('content')
    </div>
</div>
@include('layouts.frontend._footer')
<!-- global js -->
@include('layouts.frontend._assets_footer')
@yield('scripts')

</body>
</html>
