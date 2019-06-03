@extends('admin.layouts.main')
@section('title', 'Promotional List')
@section('content')
<div id="admin-promotional-list">
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
                        <th width="200">Customer</th>
                        <th v-for="column in columns"
                            v-on:click="sortBy(column.key)"
                            v-bind:class="{ active: sortKey == column.key }">
                            @{{ column.title }}
                            <i v-bind:class="'fa fa-arrow-' + (sortPromotional[column.key] > 0 ? 'up' : 'down')"></i>
                        </th>
                        <th>Item</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="promotional in collection.getData()" style="cursor: pointer; cursor: hand;">
                        <td><a v-bind:href="promotional.get('customer').getEditUrl()">@{{ promotional.get('customer').getFullname() }}</a></td>
                        <td>@{{ promotional.get('plan').get('name') }}</td>
                        <td>@{{ promotional.get('created_at') ? promotional.get('created_at').format('MMMM DD, YYYY HH:mm') : '' }}</td>
                        <td>@{{ promotional.get('ends_at') ? promotional.get('ends_at').format('MMMM DD, YYYY HH:mm') : '' }}</td>
                        <td>
                            <span v-for="item in promotional.get('items').getData()">
                                <a v-bind:href="item.getEditUrl()">@{{ item.get('name') }}</a>
                            </span>

                        </td>
                        <td><span class="label" v-bind:class="promotional.get('status') == 'active' ? 'label-success': 'label-default' ">@{{ promotional.get('status') }}</span></td>
                        <td>
                            <button v-on:click.prevent="cancel(promotional)" type="button" class="btn btn-white btn-sm" v-bind:disabled="promotional.get('status') != 'active'"><i class="fa fa-close"></i> Cancel</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center" v-if="collection.isEmpty()">
                <strong>There are no promotional yet.</strong>
            </div>
            <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
        </div>
    </list>
</div>
@endsection
