<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('meta')

        <title>@yield('title', 'ROQSTAR | Digital Audio Marketplace')</title>

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->

        <link rel="icon" type="image/png" href="{{ asset('images/favicons/favicon-16x16.png') }}" sizes="16x16">
        <link rel="icon" type="image/png" href="{{ asset('images/favicons/favicon-32x32.png') }}" sizes="32x32">
        <link rel="icon" type="image/png" href="{{ asset('images/favicons/favicon-96x96.png') }}" sizes="96x96">
        <link rel="icon" type="image/png" href="{{ asset('images/favicons/favicon-128.png') }}" sizes="128x128">
        <link rel="icon" type="image/png" href="{{ asset('images/favicons/favicon-196x196.png') }}" sizes="196x196">

        <link rel="apple-touch-icon" href="{{ asset('images/favicons/apple-touch-icon-57x57.png') }}" sizes="57x57">
        <link rel="apple-touch-icon" href="{{ asset('images/favicons/apple-touch-icon-60x60.png') }}" sizes="60x60">
        <link rel="apple-touch-icon" href="{{ asset('images/favicons/apple-touch-icon-72x72.png') }}" sizes="72x72">
        <link rel="apple-touch-icon" href="{{ asset('images/favicons/apple-touch-icon-76x76.png') }}" sizes="76x76">
        <link rel="apple-touch-icon" href="{{ asset('images/favicons/apple-touch-icon-114x114.png') }}" sizes="114x114">
        <link rel="apple-touch-icon" href="{{ asset('images/favicons/apple-touch-icon-120x120.png') }}" sizes="120x120">
        <link rel="apple-touch-icon" href="{{ asset('images/favicons/apple-touch-icon-144x144.png') }}" sizes="144x144">
        <link rel="apple-touch-icon" href="{{ asset('images/favicons/apple-touch-icon-152x152.png') }}" sizes="152x152">
        <link rel="apple-touch-icon" href="{{ asset('images/favicons/apple-touch-icon-180x180.png') }}" sizes="180x180">

        <!-- END Icons -->
        <!-- Web fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Scripts -->
    </head>
    <body class="loaded">
<!--        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>-->
        @yield('wrapper')
        @include('auth.terms')
        @yield('before-scripts')
        <script>
            window.Laravel = <?= json_encode(['csrfToken' => csrf_token()]); ?>
        </script>
        <script src="{{ elixir('js/app.js') }}"></script>
        @stack('scripts')
        @section('scripts')
        @show
        <script>
            jQuery(function () {
                // Init page helpers (Appear + CountTo plugins)
                window.App.initHelpers(['appear', 'appear-countTo']);
            });
        </script>
    </body>
</html>
