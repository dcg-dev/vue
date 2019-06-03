@extends('admin.layouts.main')
@section('title', 'FAQ Topic List')
@section('content')
<div id="admin-support-faq-topic-list">
    <div class="row">
        <div class="col-md-2">
            <a v-on:click="newTopic" class="btn btn-info">Create new FAQ Topic</a>
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
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="topic in collection.getData()">
                        <td>@{{ topic.get('id') }}</td>
                        <td>@{{ topic.get('question') }}</td>
                        <td>@{{ topic.getTruncateAnswer() }}</td>
                        <td>@{{ topic.get('created_at') ? topic.get('created_at').format('MMMM DD, YYYY') : '' }}</span></td>
                        <td>@{{ topic.get('category').get('name') }}</td>
                        <td>
                            <a v-on:click="editTopic(topic)" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                            <a v-on:click="deleteTopic(topic)" class="btn btn-white btn-sm">
                                <i class="fa fa-close"></i> Delete 
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center" v-if="collection.isEmpty()">
                <strong>There are no FAQ Topics yet.</strong>
            </div>
            <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
        </div>
    </list>
    <faq-topic v-bind:categories="categories" v-bind:topic="topic" id="faq-topic-modal" v-on:success="getList"></faq-topic>
</div>
@endsection
