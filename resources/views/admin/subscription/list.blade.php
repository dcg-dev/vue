@extends('admin.layouts.main')
@section('title', 'Subscriptions List')
@section('content')
<div id="admin-subscription-list">
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
                        <th width="300">Customer</th>
                        <th v-for="column in columns"
                            v-on:click="sortBy(column.key)"
                            v-bind:class="{ active: sortKey == column.key }">
                            @{{ column.title }}
                            <i v-bind:class="'fa fa-arrow-' + (sortSubscriptions[column.key] > 0 ? 'up' : 'down')"></i>
                        </th>
                        <th width="150">Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="subscription in collection.getData()" style="cursor: pointer; cursor: hand;">
                        <td><a v-bind:href="subscription.get('customer').getEditUrl()">@{{ subscription.get('customer').getFullname() }}</a></td>
                        <td>@{{ subscription.get('stripe_plan') }}</td>
                        <td>@{{ subscription.get('created_at') ? subscription.get('created_at').format('MMMM DD, YYYY HH:mm') : '' }}</td>
                        <td><span class="label" v-bind:class="subscription.get('status') == 'active' ? 'label-success': 'label-default' ">@{{ subscription.get('status') }}</span></td>
                        <td>
                            <button v-on:click.prevent="cancel(subscription)" type="button" class="btn btn-white btn-sm" v-bind:disabled="subscription.get('status') != 'active'"><i class="fa fa-close"></i> Cancel</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center" v-if="collection.isEmpty()">
                <strong>There are no subscriptions yet.</strong>
            </div>
            <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
        </div>
    </list>
</div>
@endsection
