@extends('admin.layouts.main')
@section('title', 'Affiliate Sales - Sales')
@section('content')
<div id="admin-affiliate-sale-list">
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
                    <th>Username</th>
                    <th>Paid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="sale in collection.getData()">,
                    <td>@{{ sale.get('id') }}</td>
                    <td>@{{ sale.get('order_item_id') }}</td>
                    <td>@{{ sale.get('amount') }}</td>
                    <td>
                        <a target='_blank' v-bind:href="sale.get('request_id') ? ('/control/affiliate/request/' + sale.get('request_id') + '/edit') : '#'">
                            @{{ sale.get('request_id')}}
                        </a>
                    </td>
                    <td>@{{ sale.get('created_at').format('MMMM DD, YYYY') }}</td>
                    <td><a v-bind:href="sale.get('user').getEditUrl()">@{{ sale.get('user').get('username') }}</a></td>
                    <td><i v-bind:class="'fa fa-' + (sale.get('is_paid') ? 'check text-success' : 'times text-danger')"></i></td>
                    <td>
                        <a v-bind:href="sale.getEditUrl('sale')" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center" v-if="collection.isEmpty()">
            <strong>There are no sales yet</strong>
        </div>
        <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
    </div>
    </list>
</div>
@endsection
