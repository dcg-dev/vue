@extends('admin.layouts.main')
@section('title', 'Tags')
@section('content')
    <div id="admin-tag-list">
        <div class="row m-b-md">
            <div class="col-md-12 text-right">
                <button class="btn btn-info" v-on:click="create">Create new Tag</button>
            </div>
        </div>
        <list v-bind:collection="collection">
            <div class="project-list table-responsive">
                <table class="table table-hover" v-if="!collection.isEmpty()">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in collection.getData()">
                        <td>@{{ item.get('name') }}</td>
                        <td class="text-right">
                            <a href="#" class="btn btn-white btn-sm" v-on:click.prevent="edit(item)">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                            <a href="#" class="btn btn-white btn-sm" v-on:click.prevent="remove(item)">
                                <i class="fa fa-close"></i> Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center" v-if="collection.isEmpty()">
                    <strong>There are no tags yet.</strong>
                </div>
                <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
            </div>
        </list>
        <tag-form v-bind:tag="tag" id="tag-modal" v-on:success="refresh"></tag-form>
    </div>
@endsection