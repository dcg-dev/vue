@extends('layouts.app')
@section('wrapper')
<div class="container-fulid">
    <div class="funy">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 warrper">
            <div id="page-container" class="header-navbar-fixed">
                <main id="main-container remove-padding">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</div>
@endsection