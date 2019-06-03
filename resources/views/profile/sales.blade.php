@extends('layouts.main')
@section('title', 'Sales')
@section('subtitle', 'All your sales in one list')
@section('content')
    @include('profile.topbar')
    <div class="content content-boxed" id="sales">
        <!-- Stats -->
        <div class="row text-uppercase">
            <div class="col-xs-6 col-sm-3">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <div class="font-s12 font-w700">Today</div>
                        <a class="h2 font-w300 text-primary" v-text="counts.today"></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-3">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <div class="font-s12 font-w700">Last Week</div>
                        <a class="h2 font-w300 text-primary" v-text="counts.lastWeek"></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-3">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <div class="font-s12 font-w700">Last Month</div>
                        <a class="h2 font-w300 text-primary" v-text="counts.lastMonth"></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-3">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <div class="font-s12 font-w700">All</div>
                        <a class="h2 font-w300 text-primary" v-text="counts.all"></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Stats -->

        <!-- Sales -->

            <sales></sales>
        </div>
        <!-- END Sales -->
    </div>
@endsection