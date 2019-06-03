@extends('admin.layouts.main')
@section('title', 'Edit Support Ticket ' . $ticket->id)
@section('content')
<div id="admin-support-ticket-edit" data-id="{{ $ticket->id }}">
    <div class="row" v-if="form.attributes.id">
        <div class='col-md-6'>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Info</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label>Username</label>
                        <a v-bind:href="form.attributes.creator.getEditUrl()" v-text="form.attributes.creator.getFullname()"></a>
                    </div>
                    <div v-bind:class="'form-group'+(errors.subject? ' has-error' : '')">
                        <label>Subject</label>
                        <input v-model="form.attributes.subject" type="text" class="form-control">
                        <span class="help-block" v-if="errors.subject">
                            <div v-for="error in errors.subject"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                    <div v-bind:class="'form-group'+(errors.description? ' has-error' : '')">
                        <label>Description</label>
                        <ckeditor :value.sync="form.attributes.description" @blur="value => form.attributes.description = value"  ref="editor"></ckeditor>
                        <span class="help-block" v-if="errors.description">
                            <div v-for="error in errors.description"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Created At</label>
                        <span v-text="form.attributes.created_at ? form.attributes.created_at.format('MMMM DD, YYYY HH:mm:ss') : ''"></span>
                    </div>
                    <div v-bind:class="'form-group'+(errors.is_solved? ' has-error' : '')">
                        <label>Solved</label>
                        <input v-model="form.attributes.is_solved" type="checkbox">
                        <span class="help-block" v-if="errors.is_solved">
                            <div v-for="error in errors.is_solved"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Posts</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <table class="table table-hover" v-if="!form.attributes.posts.isEmpty()">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Text</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="post in form.attributes.posts.getData()" v-on:click="openModalPost(post)">
                                    <td v-text="post.get('id')"></td>
                                    <td><a v-bind:href="post.get('user').getEditUrl()" v-text="post.get('user').getFullname()"></a></td>
                                    <td v-text="post.getTruncateText()"></td>
                                    <td v-text="post.get('created_at') ? post.get('created_at').format('MMMM DD, YYYY') : ''"></td>
                                </tr>
                            </tbody>
                        </table>
                        <span v-else>Support Ticket doesn't contain any posts</span>
                    </div>
                    <div class="form-group">
                        <ckeditor :value.sync="replyText" @blur="value => replyText = value" ref="editor2"></ckeditor>
                        <button v-on:click="reply($event)" type="submit" class="btn btn-success btn-block">
                            Reply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-2">
            <div class="form-group">
                <button v-on:click="submit($event)" type="submit" class="btn btn-primary btn-block">
                    Save
                </button>
            </div>
        </div>
        <div class="col-md-3 col-md-offset-2">
            <div class="form-group">
                <a href="/control/support/ticket/list" class="btn btn-info btn-block">
                    Go Back
                </a>
            </div>
        </div>
    </div>
    <ticket-post v-bind:post="currentViewPost" id="modal-post" v-on:success="getTicket"></ticket-post>
</div>

@endsection