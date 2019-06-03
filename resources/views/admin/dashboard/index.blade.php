@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
    <div id="dashboard">
        <div v-if="info" class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-warning">
                        <h5>Users</h5>
                        <div class="pull-right" style="margin-top: -3px;">
                            <dashboard-dd v-model="current.users.type"></dashboard-dd>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <h1 class="no-margins" v-text="info.users.total">0</h1>
                                <small>Total</small>
                            </div>
                            <div class="col-sm-6">
                                <h1 class="no-margins"><i v-if="current.users.loading"
                                                          class="fa fa-circle-o-notch fa-spin"></i><span
                                            v-if="!current.users.loading" v-text="info.users.today">0</span></h1>
                                <small v-text="current.users.type"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-info">
                        <h5>Items</h5>
                        <div class="pull-right" style="margin-top: -3px;">
                            <dashboard-dd v-model="current.items.type"></dashboard-dd>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <h1 class="no-margins" v-text="info.items.total">0</h1>
                                <small>Total</small>
                            </div>
                            <div class="col-sm-6">
                                <h1 class="no-margins"><i v-if="current.items.loading"
                                                          class="fa fa-circle-o-notch fa-spin"></i><span
                                            v-if="!current.items.loading" v-text="info.items.today">0</span></h1>
                                <small v-text="current.items.type"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-success">
                        <h5>Processed Sales</h5>
                        <div class="pull-right" style="margin-top: -3px;">
                            <dashboard-dd v-model="current.processed_sales.type"></dashboard-dd>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <h1 class="no-margins" v-text="info.processed_sales.total">0</h1>
                                <small>Total</small>
                            </div>
                            <div class="col-sm-6">
                                <h1 class="no-margins"><i v-if="current.processed_sales.loading"
                                                          class="fa fa-circle-o-notch fa-spin"></i><span
                                            v-if="!current.processed_sales.loading" v-text="info.processed_sales.today">0</span>
                                </h1>
                                <small v-text="current.processed_sales.type"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-primary">
                        <h5>Average Commission</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">@{{ info.commision.average.toFixed(2) | currency }}%</h1>
                        <small>Average Commission</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-primary">
                        <h5>Earnings</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b">
                            <div class="col-sm-6">
                                <h1 class="no-margins" v-text="'$ ' + info.earnings.today">$ 0.00</h1>
                                <small>Today</small>
                            </div>
                            <div class="col-sm-6">
                                <h1 class="no-margins" v-text="'$ ' + info.earnings.month">$ 0.00</h1>
                                <small>This month</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h1 class="no-margins" v-text="'$ ' + info.earnings.year">$ 0.00</h1>
                                <small>This year</small>
                            </div>
                            <div class="col-sm-6">
                                <h1 class="no-margins" v-text="'$ ' + info.earnings.total">$ 0.00</h1>
                                <small>Total</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-primary">
                        <h5>Plans</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-hover table-striped no-margins">
                            {{--<thead>--}}
                            {{--<tr>--}}
                            {{--<th>Plan</th>--}}
                            {{--<th>Price</th>--}}
                            {{--<th>Users</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            <tbody>
                            <tr v-if="info.plans" v-for="plan in info.plans">
                                <td>
                                    @{{plan.name}}
                                </td>
                                <td>$@{{ plan.price }}</td>
                                <td>@{{ plan.subscriptions_count }} @{{ plan.subscriptions_count == 1 ? ' user' : ' users'}}</td>
                            </tr>
                            <tr v-if="!info.plans || !info.plans.length">
                                <td colspan="3" class="text-center">No plans yet</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="info" class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Earnings In $</h5>
                    </div>
                    <div class="ibox-content">
                        <chartjs-line :labels="earningsData.labels" :datasets="earningsData.datasets" :height="320"
                                      :width="555" :bind="true" :option="chartOption"></chartjs-line>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Sales</h5>
                    </div>
                    <div class="ibox-content">
                        <chartjs-line :labels="salesData.labels" :datasets="salesData.datasets" :height="320"
                                      :width="555" :bind="true" :option="chartOption"></chartjs-line>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="info" class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Top Products</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-hover no-margins">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>Sales</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in info.items.top">
                                <td><a v-bind:href="item.item.getEditUrl()">@{{ item.item.get('name') }}</a></td>
                                <td class="text-center" width="50">@{{ item.count  }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Last Orders</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-hover no-margins">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="order in info.orders.getData()">
                                <td><a v-bind:href="order.getEditUrl()">@{{ order.get('id')}}</a></td>
                                <td>@{{ order.get('created_at') ? order.get('created_at').format('MMMM DD, YYYY') : '' }}</td>
                                <td>
                                    <a v-bind:href="order.get('customer').getEditUrl()">@{{ order.get('customer').getFullname() }}</a>
                                </td>
                                <td>@{{ order.get('items').getData().length  }}</td>
                                <td class="text-center text-success" width="50">$@{{ order.get('amount')  }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Last Orders</h5>
                    </div>
                    <div class="ibox-content">
                        <subscription-list></subscription-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
