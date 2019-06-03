@extends('admin.layouts.main')
@section('title', 'Item List')
@section('content')
<div id="admin-item-list">
    <div class="row">
        <div class="col-md-2">
            <a href="{{ route('admin.item.create') }}" class="btn btn-info">Create new Item</a>
        </div>
        <div class="col-md-offset-5 col-md-5">
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
                        <th>Owner</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in collection.getData()">
                        <td>@{{ item.get('id') }}</td>
                        <td>@{{ item.get('name') }}</td>
                        <td>@{{ item.get('slug') }}</td>
                        <td>@{{ item.get('price') }}</td>
                        <td><item-status :status="item.get('status')"></item-status></td>
                        <td>@{{ item.get('created_at') ? item.get('created_at').format('MMMM DD, YYYY') : '' }}</span></td>
                        <td><a v-bind:href="item.get('creator').getEditUrl()" v-text="item.get('creator').getFullname()"></a></span></td>
                        <td>
                            <a v-bind:href="item.getEditUrl()" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                            <a v-on:click="deleteItem(item)" class="btn btn-white btn-sm">
                                <i class="fa fa-close"></i> Delete 
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center" v-if="collection.isEmpty()">
                <strong>There are no items yet.</strong>
            </div>
            <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
        </div>
    </list>
</div>
@endsection
