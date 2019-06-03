@extends('admin.layouts.main')
@section('title', 'User Skills')
@section('content') 
<div id="admin-user-skill-list">
    <div class="row">
        <div class="col-md-2">
            <a v-on:click="newSkill" class="btn btn-info">Create new User Skill</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Enabled</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="'undefined' !== typeof list && list.length > 0">
                        <tr v-for="skill in list">
                            <td>@{{ skill.id }}</td>
                            <td>@{{ skill.name }}</td>
                            <td>@{{ skill.slug }}</td>
                            <td><i v-bind:class="'fa fa-'+(skill.enabled ? 'check text-success' : 'times text-danger')"></i></td>
                            <td>@{{ skill.created_at | moment }}</td>
                            <td>
                                <button class="btn btn-xs btn-success" v-on:click="toggleApprove(skill.slug, true, $event)" v-if="!skill.enabled">
                                    <i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Approve"></i>
                                </button>
                                <button class="btn btn-xs btn-danger" v-on:click="toggleApprove(skill.slug, false, $event)" v-if="skill.enabled">
                                    <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Disapprove"></i>
                                </button>
                                <button v-on:click="editSkill(skill)" class="btn btn-xs btn-info">
                                    <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i>
                                </button>
                                <button v-on:click="deleteSkill(skill.slug, $event)" class="btn btn-xs btn-danger">
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
    <user-skill v-if="form" v-bind:form="form" id="user-skill-modal" v-on:success="getList(pagination.current_page, pagination.per_page)"></user-skill>
</div>
@endsection