@extends('admin.layouts.main')
@section('title', 'FAQ Category List')
@section('content')
<div id="admin-support-faq-category-list">
    <div class="row">
        <div class="col-md-2">
            <a v-on:click="newCategory" class="btn btn-info">Create new FAQ Category</a>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in collection.getData()">
                        <td>@{{ category.get('id') }}</td>
                        <td>@{{ category.get('name') }}</td>
                        <td>@{{ category.get('created_at') ? category.get('created_at').format('MMMM DD, YYYY') : '' }}</span></td>
                        <td>
                            <a v-on:click="editCategory(category)" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                            <a v-on:click="deleteCategory(category)" class="btn btn-white btn-sm">
                                <i class="fa fa-close"></i> Delete 
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center" v-if="collection.isEmpty()">
                <strong>There are no FAQ Categories yet.</strong>
            </div>
            <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
        </div>
    </list>
    <faq-category v-bind:category="category" id="faq-category-modal" v-on:success="getList"></faq-category>
</div>
@endsection
