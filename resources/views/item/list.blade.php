@extends('layouts.main')
@section('title', "Items")
@section('subtitle', 'Your items for sale')
@section('content')
    @include('profile.topbar')
    <div class="content content-boxed" id="item-list">
        <div v-bind:class="'block block-rounded'+(loading ? ' block-opt-refresh' : '')">
            <div class="block-header">
                <ul class="block-options">
                    <a href="{{route('profile.item.upload')}}" type="button" class="btn btn-default btn-outline"><i
                                class="fa fa-plus"></i> Add new</a>

                    <a class="btn btn-default btn-outline" type="button" v-on:click="get"><i class="si si-refresh"></i></a>

                </ul>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter">
                        <tbody>
                        <tr v-if="!items.isEmpty()" v-for="item in items.getData()">
                            <td class="text-center" style="width: 200px;">
                                <a style="width: 180px;" v-bind:href="item.getUrl()">
                                    <img class="img-responsive" v-bind:src="item.get('image')" alt="">
                                </a>
                            </td>
                            <td>
                                <h4>
                                    <a v-bind:href="item.getUrl()" v-text="item.get('name')"></a>
                                    <span v-if="item.get('active_promo').length > 0" class="label label-info"
                                          style="font-size: 9px; position: relative; top: -3px">Promo</span>
                                </h4>
                                <p>
                                    <a class="font-w600" v-bind:href="item.get('creator').getUrl()"
                                       v-text="item.get('creator').getFullname()">
                                    </a>
                                </p>
                                <div v-if="item.isApproved()">
                                    <p class="remove-margin-b">
                                        Added: <span class="text-gray-dark"
                                                     v-text="item.get('created_at').format('d. MMMM Y')"></span><br>
                                    </p>
                                    <p class="remove-margin-b">
                                        Last Update: <span class="text-gray-dark"
                                                           v-text="item.get('updated_at').format('d. MMMM Y')"></span><br>
                                    </p>
                                </div>
                                <div v-if="!item.isApproved()">
                                    <p class="remove-margin-b">
                                        Purchases: <span class="text-gray-dark"
                                                         v-text="item.get('count_sales', 0)"></span><br>
                                    </p>
                                </div>
                                <p class="remove-margin-b">
                                    Item Sales: <span class="text-gray-dark">$<span
                                                v-text="item.getTotalSales()"></span></span>
                                </p>
                                Status:
                                <item-status v-bind:status="item.get('status')"></item-status>
                                <em class="text-danger" v-if="item.isDeclined()"
                                    v-text="item.get('decline_reason', '')"></em>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-default" href="{{ route('profile.promotions') }}">
                                    <i class="si si-rocket push-5-r text-warning"></i>Promote
                                </a>
                                <a v-bind:href="item.getUrl()+'/edit'" class="btn btn-sm btn-default" type="button">
                                    <i class="fa fa-pencil push-5-r text-success"></i>Edit
                                </a>
                                <button class="btn btn-sm btn-default" type="button" v-on:click.prevent="remove(item)">
                                    <i class="fa fa-times push-5-r text-danger"></i>Delete
                                </button>
                            </td>
                            <td class="text-center">
                                <span class="h1 font-w700 text-success">
                                    <span v-if="!item.isFree()">
                                        $<span v-text="item.getPrice()"></span>
                                    </span>
                                    <span v-if="item.isFree()">
                                        Free
                                    </span>
                                </span>
                                {{--<p class="remove-margin-b"><span v-text="item.get('count_sales', 0)"></span> purchases</p>--}}
                                <div>
                                    <stars :rating="item.get('rating', 0)"></stars>
                                    <p class="remove-margin-b font-s12"><span v-text="item.get('count_rating', 0)"></span>
                                        Ratings</p>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="items.isEmpty()" class="text-center">
                            <td>
                                <div>
                                    You don't have any items.
                                </div>
                                <a href="{{route('profile.item.upload')}}" class="btn btn-link btn-sm">Do you want to
                                    create a new item?</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <collection-pagination :collection="items" v-on:go="paginate"></collection-pagination>
    </div>
@endsection
