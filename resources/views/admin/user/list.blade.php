@extends('admin.layouts.main')
@section('title', 'User List')
@section('content')
<div id="admin-user-list">
    <div class="row">
        <div class="col-md-2">
            <a href="{{ route('admin.user.create') }}" class="btn btn-info">Create new user</a>
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
                        <th>Plan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in collection.getData()">
                        <td>@{{ user.get('id') }}</td>
                        <td>@{{ user.get('username') }} <i v-if="!user.get('activated')" class="text-danger">(not activated)</i></td>
                        <td>@{{ user.get('role') }}</td>
                        <td>@{{ user.get('email') }}</td>
                        <td>@{{ user.get('created_at') ? user.get('created_at').format('MMMM DD, YYYY') : '' }}</span></td>
                        <td>
                            <span v-if="user.get('plan')" class="label label-success">@{{ user.get('plan').name }}</span>
                            <span v-else class="label label-danger">Undefined</span></td>
                        <td>
                            <a v-bind:href="user.getEditUrl()" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                            <a v-on:click="deleteUserApprove(user)" class="btn btn-white btn-sm">
                                <i class="fa fa-close"></i> Delete 
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center" v-if="collection.isEmpty()">
                <strong>There are no users yet.</strong>
            </div>
            <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
        </div>
    </list>
</div>
@endsection
