<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="Envire" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('meta')
        <title>@yield('title') {{ config('app.name') }} Control Panel</title>
        <link rel="stylesheet" href="{{ elixir('admin/css/vendor.css') }}">
        <link rel="stylesheet" href="{{ elixir('admin/css/app.css') }}">
        @yield('styles')
    </head>
    <body class="fixed-sidebar fixed-nav">
        <div id="page-loader" class="fade in">
            <span class="spinner"></span>
        </div>
        @yield('wrapper')
        @yield('before-scripts')
        <script>
            window.Laravel = <?= json_encode(['csrfToken' => csrf_token()]); ?>
        </script>
        <script src="{{ elixir('admin/js/vendor.js') }}"></script>
        <script src="{{ elixir('admin/js/app.js') }}"></script>
        @stack('scripts')
        @section('scripts')
        @show

    </body>
</html>
