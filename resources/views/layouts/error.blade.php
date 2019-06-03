@extends('layouts.app')
@section('wrapper')
    <div class="content bg-white text-center pulldown overflow-hidden" id="error-page">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <!-- Error Titles -->
            @yield('content')
            <!-- END Error Titles -->
            </div>
        </div>
    </div>
    <div class="content pulldown text-muted text-center">
        Would you like to let us know about it?<br>
        <a class="link-effect" href="/support/ticket/list">Report it</a> or
        <a class="link-effect" href="/">Go Back to
            Homepage</a>
    </div>
@endsection