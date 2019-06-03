@extends('admin.layouts.main')
@section('title', 'Affiliate Sales - Requests')
@section('content')
<div id="admin-affiliate-request-list">
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
                    <th>Closed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="request in collection.getData()">
                    <td>@{{ request.get('id') }}</td>
                    <td>@{{ request.get('created_at').format('MMMM DD, YYYY') }}</td>
                    <td><a v-bind:href="request.get('user').getEditUrl()">@{{ request.get('user').get('username') }}</a></td>
                    <td><i v-bind:class="'fa fa-' + (request.get('is_closed') ? 'check text-success' : 'times text-danger')"></i></td>
                    <td>
                        <a v-bind:href="request.getEditUrl('request')" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                        <a v-if="!request.get('is_closed')" v-on:click="closeRequest(request)" class="btn btn-white btn-sm">
                            <i class="fa fa-check"></i> Close 
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center" v-if="collection.isEmpty()">
            <strong>There are no requests yet.</strong>
        </div>
        <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
    </div>
    </list>
</div>
@endsection
