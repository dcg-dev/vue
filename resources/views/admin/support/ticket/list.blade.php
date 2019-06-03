@extends('admin.layouts.main')
@section('title', 'Support Ticket List')
@section('content')
<div id="admin-support-ticket-list">
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
                        <th>Creator</th>
                        <th>Posts</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="ticket in collection.getData()" style="cursor: pointer; cursor: hand;">
                        <td>@{{ ticket.get('id') }}</td>
                        <td>@{{ ticket.get('subject') }}</td>
                        <td>@{{ ticket.getTruncateDescription() }}</td>
                        <td><i v-bind:class="'fa fa-' + (ticket.get('is_solved') ? 'check text-success' : 'times text-danger')"></i></td>
                        <td>@{{ ticket.get('created_at') ? ticket.get('created_at').format('MMMM DD, YYYY') : '' }}</span></td>
                        <td><a v-bind:href="ticket.get('creator').getEditUrl()">@{{ ticket.get('creator').getFullname() }}</a></td>
                        <td>@{{ ticket.get('countPosts') }}</td>
                        <td>
                            <a v-bind:href="ticket.getEditUrl()" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                            <a v-on:click="deleteTicket(ticket)" class="btn btn-white btn-sm">
                                <i class="fa fa-close"></i> Delete 
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center" v-if="collection.isEmpty()">
                <strong>There are no Support Tickets yet.</strong>
            </div>
            <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
        </div>
    </list>
</div>
@endsection
