@extends('admin.layouts.app')
@section('wrapper')
<div id="wrapper" class="fade">
    <!-- Navigation -->
    @include('admin.layouts.partials.navigation')
    <!-- Page wraper -->
    <div id="page-wrapper" class="gray-bg">
        <!-- Page wrapper -->
        @include('admin.layouts.partials.topnavbar')
        <!-- Main view  -->
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-md-6">
                <h2>@yield('title')</h2>
                <ol class="breadcrumb">
                    @yield('breadcrumb')
                </ol>
            </div>
            <div class="col-md-6 m-t-md text-right">
                @yield('page-navigation')
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            @if (isset($message))
            <div class="alert alert-{{$message['type'] or 'warning'}}">
                {{$message['message'] or ''}}
            </div>
            @endif
            @yield('content')
        </div>
        <!-- Footer -->
        @include('admin.layouts.partials.footer')
    </div>
    <!-- End page wrapper-->
</div>
@endsection
