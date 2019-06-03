@extends('layouts.app')
@section('wrapper')
    <div class="container-fulid">
        @include('layouts.partials.topbar-mobile')
        <div class="funy">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 warrper">
                <div id="page-container" class="header-navbar-fixed">
                    @include('layouts.partials.topbar')
                    <main id="main-container" style="min-height: 100vh;">
                        @if(Route::current()->getName() != 'start_selling')
                            @include('layouts.partials.subtopbar')
                        @endif
                        <div id="load-box" class="hide">
                            @yield('content')
                        </div>
                    </main>
                    @include('layouts.partials.footer')
                </div>
            </div>
        </div>
    </div>
@endsection
