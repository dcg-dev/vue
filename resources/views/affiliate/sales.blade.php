@extends('layouts.main')
@section('title', 'Affiliate Sales')
@section('subtitle', 'Income from sales that you promoted')
@section('content')
    @include('affiliate.partials.topbar', ['backgroundImage' => 'forum_bg'])
    <div class="content content-boxed overflow-hidden" id="affiliate-sales">

        @include('affiliate.partials.header_tiles')

        <div class="block-content block-content-full block-content-mini text-white font-w600 push-10-t text-right bg-white">
            <a href="{{ route('profile.affiliate.link') }}" class="btn btn-default btn-rounded btn-md">Generate New
                Link</a>
            <button id="request-button" v-if="currentUser && !currentUser.get('hasAffiliateRequest')"
                    v-on:click="modalRequest" class="btn btn-success-modern btn-rounded btn-md">Request Payout
            </button>
            <button v-if="currentUser && currentUser.get('hasAffiliateRequest')" data-style="expand-right"
                    class="btn btn-primary btn-rounded btn-md" disabled>Request was sent
            </button>
        </div>
        <!-- Sales -->
        <div v-bind:class="'block' + (loading ? ' block-opt-refresh' : '')">
            <div class="block-header bg-white">
                <ul class="block-options">
                    <li class="dropdown">
                        <button type="button" data-toggle="dropdown" aria-expanded="false">Filter <span
                                    class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li v-bind:class="isPaidFilter == 'all' ? 'active' : ''"
                                v-on:click="changePaidFilter('all')">
                                <a tabindex="-1" href="javascript:void(0)">
                                    <span class="badge badge-muted pull-right" v-if="'undefined' !== typeof info.total_referrals"
                                          v-text="info.total_referrals"></span>
                                    <span class="badge badge-muted pull-right" v-else>NaN</span>
                                    all
                                </a>
                            </li>
                            <li v-bind:class="isPaidFilter == 'false' ? 'active' : ''"
                                v-on:click="changePaidFilter('false')">
                                <a tabindex="-1" href="javascript:void(0)">
                                    <span class="badge badge-muted pull-right" v-if="'undefined' !== typeof info.unpaid_amount"
                                          v-text="info.unpaid_amount"></span>
                                    <span class="badge badge-muted pull-right" v-else>NaN</span>
                                    unpaid
                                </a>
                            </li>
                            <li v-bind:class="isPaidFilter == 'true' ? 'active' : ''"
                                v-on:click="changePaidFilter('true')">
                                <a tabindex="-1" href="javascript:void(0)">
                                    <span class="badge badge-muted pull-right" v-if="'undefined' !== typeof info.paid_amount"
                                          v-text="info.paid_amount"></span>
                                    <span class="badge badge-muted pull-right" v-else>NaN</span>
                                    paid
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <h5 class="block-title">All Orders</h5>
            </div>
            <div class="block-content block-content-full bg-gray-lighter text-center" v-if="!list.isEmpty()">
                <div class="btn-group">
                    <button v-bind:class="'btn btn-sm btn-default ' + (dateFilter == 'month' ? 'active' : '')"
                            v-on:click="changeDateFilter('month')">
                        Last 30 days
                    </button>
                    <button v-bind:class="'btn btn-sm btn-default ' + (dateFilter == 'sixMonth' ? 'active' : '')"
                            v-on:click="changeDateFilter('sixMonth')">
                        Last 6 months
                    </button>
                    <button v-bind:class="'btn btn-sm btn-default ' + (dateFilter == 'year' ? 'active' : '')"
                            v-on:click="changeDateFilter('year')">
                        Last year
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="table-responsive" v-if="!list.isEmpty()">
                    <table class="table table-hover table-vcenter">
                        <tbody>
                        <tr v-for="sale in list.getData()">
                            <td class="text-center text-muted" style="width: 200px;"
                                v-text="sale.get('affiliable').get('created_at').format('MMMM D, Y')">
                            </td>
                            <td>
                                @{{ (sale.get('affiliable_type') == "App\\Models\\Subscription") ? 'Subscription' : 'Item' }}
                                (#ID @{{ sale.get('affiliable_id') }})
                            </td>
                            <td>
                                <a class="font-w600" target="_blank"
                                   :href="'/user/'+sale.get('affiliable').get('customer').username"
                                   v-if="sale.get('affiliable_type') == 'App\\Models\\Subscription'">
                                    @{{ sale.get('affiliable').get('customer').username}}
                                    (@{{ sale.get('affiliable').get('stripe_plan')}})
                                </a>
                                <a class="font-w600" target="_blank"
                                   :href="sale.get('affiliable').get('item').getUrl()"
                                   v-else>
                                    @{{ sale.get('affiliable').get('item').get('name') }}
                                </a>
                            </td>
                            <td class="text-right">
                                <span v-bind:class="'label label-' + (sale.get('is_paid') ? 'success' : 'default')"
                                      v-text="sale.get('is_paid') ? 'paid' : 'unpaid'"></span>
                            </td>
                            <td class="text-right" style="width: 80px;">
                                <span class="font-w600 text-success"
                                      v-text="'+ $' + sale.get('amount').toFixed(2)"></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center text-gray push-50 push-20-t" v-else>
                    <p>You don't have any affiliate sales yet.</p>
                </div>
            </div>
        </div>
        <!-- END Sales -->
        <!-- Disabled and Active States -->
        <div class="block-content text-center">
            <collection-pagination :collection="list" v-on:go="getList"></collection-pagination>
        </div>
        <!-- END Disabled and Active States -->

        <affiliate-request id="modal-request" v-on:madeRequest="madeRequest" :user="currentUser"></affiliate-request>
    </div>
@endsection