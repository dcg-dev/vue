@extends('admin.layouts.main')
@section('title', 'Orders List')
@section('content')
<div id="admin-order-list">
    <div class="row">
        <div class="col-md-offset-8 col-md-4">
            <div class="pull-right form-group">
                <input type="text" class="form-control" type="text" placeholder="Type and hit enter.." 
                    v-model="search" 
                    v-on:keyup.enter="getList()" />
            </div>
            <div class="pull-right m-t-sm m-r-sm">
                Search: 
            </div>
        </div>
    </div>
    <list v-bind:collection="collection">
        <div class="project-list table-responsive">
            <table class="table table-hover" v-if="!collection.isEmpty()">
                <thead>
                    <tr>
                        <th v-for="column in columns"
                            v-on:click="sortBy(column.key)"
                            v-bind:class="{ active: sortKey == column.key }">
                            @{{ column.title }}
                            <i v-bind:class="'fa fa-arrow-' + (sortOrders[column.key] > 0 ? 'up' : 'down')"></i>
                        </th>
                        <th>Customer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in collection.getData()" style="cursor: pointer; cursor: hand;">
                        <td>@{{ order.get('id') }}</td>
                        <td>@{{ order.get('amount') }}</td>
                        <td>@{{ order.get('payment_type') }}</td>
                        <td>@{{ order.get('order_status') }}</td>
                        <td>@{{ order.get('created_at') ? order.get('created_at').format('MMMM DD, YYYY') : '' }}</span></td>
                        <td><a v-bind:href="order.get('customer').getEditUrl()">@{{ order.get('customer').getFullname() }}</a></td>
                        <td>
                            <a v-bind:href="order.getEditUrl()" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                            <a v-on:click="deleteOrder(order)" class="btn btn-white btn-sm">
                                <i class="fa fa-close"></i> Delete 
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center" v-if="collection.isEmpty()">
                <strong>There are no orders yet.</strong>
            </div>
            <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
        </div>
    </list>
</div>
@endsection
