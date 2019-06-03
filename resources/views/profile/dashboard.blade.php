@extends('layouts.main')
@section('title', 'Dashboard')
@section('subtitle', 'Hey, ' . ($currentUser->firstname ?  $currentUser->firstname : $currentUser->username) . '! Good to see you.')
@section('content')
    @include('profile.topbar')
    <div class="content content-boxed" id="profile-dashboard">
        <!-- Stats -->
        <div class="row" v-if="info">
            <div class="col-xs-6 col-sm-3">
                <dashboard-counters url="/api/profile/dashboard/visitors" label="Unique Visitors"></dashboard-counters>
            </div>
            <div class="col-xs-6 col-sm-3">
                <dashboard-counters url="/api/profile/dashboard/processed-sales" label="Processed Sales"></dashboard-counters>
            </div>
            <div class="col-xs-6 col-sm-3">
                <dashboard-counters url="/api/profile/dashboard/earnings" label="Earnings"></dashboard-counters>
            </div>
            <div class="col-xs-6 col-sm-3">
                <dashboard-counters url="/api/profile/dashboard/average-sale" label="Average Sale"></dashboard-counters>
            </div>
        </div>
        <!-- END Stats -->

        <!-- Charts -->
        <div class="row" v-if="info">
            <div class="col-md-6">
                <div id="earnings-statistics" class="block block-rounded block-opt-refresh-icon8">
                    <div class="block-header">
                        <ul class="block-options">
                            <li>
                                <button type="button" v-on:click="refreshStatistics('earnings')"><i
                                            class="si si-refresh"></i></button>
                            </li>
                        </ul>
                        <h3 class="block-title">Earnings in $</h3>
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter text-center">
                        <!-- Chart.js Charts (initialized in js/pages/base_pages_dashboard_v2.js), for more examples you can check out http://www.chartjs.org/docs/ -->
                        <div style="height: 320px;">
                            <chartjs-line :labels="earningsData.labels" :datasets="earningsData.datasets" :height="320"
                                          :width="555" :bind="true" :option="chartOption"></chartjs-line>
                        </div>
                    </div>
                    <div class="block-content text-center">
                        <div class="row items-push-2x text-center push-20-t">
                            <div class="col-xs-6 col-lg-3">
                                <div class="push-15"><i class="si si-wallet fa-2x"></i></div>
                                <div class="h5 text-muted" v-text="'$' + info.earnings.sales"></div>
                                <div class="h6 text-muted">Sales</div>
                            </div>
                            <div class="col-xs-6 col-lg-3">
                                <div class="push-15"><i class="si si-bar-chart fa-2x"></i></div>
                                <div class="h5 text-muted"
                                     v-text="((info.earnings.earnings > 0) ? ('+' + info.earnings.earnings) : info.earnings.earnings) + '%'"></div>
                                <div class="h6 text-muted">Earnings</div>
                            </div>
                            <div class="col-xs-6 col-lg-3">
                                <div class="push-15"><i class="fa fa-eye fa-2x"></i></div>
                                <div class="h5 text-muted"
                                     v-text="((info.earnings.visitors > 0) ? ('+' + info.earnings.visitors) : info.earnings.visitors) + '%'"></div>
                                <div class="h6 text-muted">Visitors</div>
                            </div>
                            <div class="col-xs-6 col-lg-3">
                                <div class="push-15"><i class="si si-user-following fa-2x"></i></div>
                                <div class="h5 text-muted"
                                     v-text="((info.earnings.followers > 0) ? ('+' + info.earnings.followers) : info.earnings.followers) + '%'"></div>
                                <div class="h6 text-muted">Followers</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div id="sales-statistics" class="block block-rounded block-opt-refresh-icon8">
                    <div class="block-header">
                        <ul class="block-options">
                            <li>
                                <button type="button" v-on:click="refreshStatistics('sales')"><i
                                            class="si si-refresh"></i></button>
                            </li>
                        </ul>
                        <h3 class="block-title">Sales</h3>
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter text-center">
                        <!-- Chart.js Charts (initialized in js/pages/base_pages_dashboard_v2.js), for more examples you can check out http://www.chartjs.org/docs/ -->
                        <div style="height: 320px;">
                            <chartjs-line :labels="salesData.labels" :datasets="salesData.datasets" :height="320"
                                          :width="555" :bind="true" :option="chartOption"></chartjs-line>
                        </div>
                    </div>
                    <div class="block-content text-center">
                        <div class="row items-push-2x text-center push-20-t">
                            <div class="col-xs-6 col-lg-3">
                                <div class="push-15"><i class="si si-wallet fa-2x"></i></div>
                                <div class="h5 text-muted" v-text="info.sales.sales"></div>
                                <div class="h6 text-muted">Sales</div>
                            </div>
                            <div class="col-xs-6 col-lg-3">
                                <div class="push-15"><i class="si si-rocket fa-2x"></i></div>
                                <div class="h5 text-muted" v-text="info.sales.top_item"></div>
                                <div class="h6 text-muted">Top Item</div>
                            </div>
                            <div class="col-xs-6 col-lg-3">
                                <div class="push-15"><i class="fa fa-archive fa-2x"></i></div>
                                <div class="h5 text-muted"
                                     v-text="((info.sales.comments > 0) ? ('+' + info.sales.comments) : info.sales.comments) + '%'"></div>
                                <div class="h6 text-muted">Comments</div>
                            </div>
                            <div class="col-xs-6 col-lg-3">
                                <div class="push-15"><i class="fa fa-paint-brush fa-2x"></i></div>
                                <div class="h5 text-muted"
                                     v-text="((info.sales.ratings > 0) ? ('+' + info.sales.ratings) : info.sales.ratings) + '%'"></div>
                                <div class="h6 text-muted">Ratings</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Charts -->
    </div>
@endsection