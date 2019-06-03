@extends('admin.layouts.main')
@section('title', 'Blog Stories')
@section('content') 
<div class="row">
    <div class="col-md-2">
        <a href="{{ route('admin.blog.story.create') }}" class="btn btn-info">Create new Blog Story</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive" id="admin-blog-story-list">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Creator</th>
                        <th>Approved</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody v-if="'undefined' !== typeof list && list.length > 0">
                    <tr v-for="story in list">
                        <td>@{{ story.id }}</td>
                        <td>@{{ story.title }}</td>
                        <td>@{{ story.slug }}</td>
                        <td>@{{ story.creator.username }}</td>
                        <td><i v-bind:class="'fa fa-'+(story.approved ? 'check text-success' : 'times text-danger')"></i></td>
                        <td>@{{ story.created_at | moment }}</td>
                        <td>
                            <button class="btn btn-xs btn-success" v-on:click="toggleApprove(story.slug, true, $event)" v-if="!story.approved">
                                <i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Approve"></i>
                            </button>
                            <button class="btn btn-xs btn-danger" v-on:click="toggleApprove(story.slug, false, $event)" v-if="story.approved">
                                <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Disapprove"></i>
                            </button>
                            <button v-on:click="editStory(story.slug)" class="btn btn-xs btn-info">
                                <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i>
                            </button>
                            <button v-on:click="deleteStory(story.slug, $event)" class="btn btn-xs btn-danger">
                                <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="block-content text-center" v-if="pagination.total > pagination.to">
                <nav>
                    <pagination  v-bind:pagination="pagination"
                        v-on:click.native="getList(pagination.current_page, pagination.per_page)"
                        :offset="offset">
                    </pagination>
                </nav>
            </div><!--block-content text-center-->
        </div><!--table-responsive-->
    </div>
</div>
@endsection