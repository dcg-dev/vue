@extends('admin.layouts.main')
@section('title', 'Categories')
@section('content')
<div id="admin-categories" class="ibox">
    <div class="ibox-title">
        <h2>Categories <small>This is categories use on frontend side</small></h2>
    </div>
    <div v-bind:class="'ibox-content' + (loading.list ? 'ibox-loading' : '')">
        <div class="ibox-loader">
            <span class="spinner-small"></span>
        </div>
        <draggable @end="move"  class="draggable">
            <transition-group>
                <div class="three-item" v-for="element in list" :key="element.index" v-bind:data-id="element.id">
                    <div class="vote-item">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="vote-actions">
                                    <a href="#" class="m-t-md block">
                                        <i class="fa fa-lg fa-arrows"> </i>
                                    </a>
                                </div>
                                <a href="#" class="vote-title">
                                    <span v-text="element.name"></span> 
                                    <small class="text-danger" v-if="!element.enabled">Disabled</small>
                                </a>
                                <div class="vote-info">
                                    <i class="fa fa-pencil"></i> <a href="#" v-on:click.prevent="showEdit(element)">Edit category</a>
                                    <i class="fa fa-times"></i> <a href="#" v-on:click.prevent="remove(element)">Delete</a>
                                    <i class="fa fa-plus"></i> <a href="#" v-on:click.prevent="addChild(element)">Add child category</a>
                                </div>
                            </div>
                            <div class="col-md-2 text-right">
                                <a v-bind:href="'/category/'+element.slug" class="btn btn-info btn-sm" target="__blank">View on the site</a>
                            </div>
                        </div>
                    </div>
                    <draggable @end="move" class="draggable">
                        <transition-group>
                            <div class="three-item" v-for="child in element.childs" :key="child.index" v-bind:data-id="child.id">
                                <div class="vote-item">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="vote-actions">
                                                <a href="#" class="m-t-md block">
                                                    <i class="fa fa-lg fa-arrows"> </i>
                                                </a>
                                            </div>
                                            <a href="#" class="vote-title">
                                                <span v-text="child.name"></span> 
                                                <small class="text-danger" v-if="!child.enabled">Disabled</small>
                                            </a>
                                            <div class="vote-info">
                                                <i class="fa fa-pencil"></i> <a href="#" v-on:click.prevent="showEdit(child)">Edit category</a>
                                                <i class="fa fa-times"></i> <a href="#" v-on:click.prevent="remove(child)">Delete</a>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <a v-bind:href="'/category/'+child.slug" class="btn btn-info btn-sm" target="__blank">View on the site</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition-group>
                    </draggable>
                </div>
            </transition-group>
        </draggable>
        <div class="m-b-lg m-t-lg text-center" v-if="!list.length">
            <strong>No category has been created yet!</strong>
        </div>
        <div class="m-t-lg text-center">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-2 col-lg-offset-5">
                    <button class="btn btn-primary btn-block" v-on:click="showCreate">Add new category</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="create-category" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" v-text="(forms.modal.id) ? 'Edit '+forms.modal.name+' category' : 'Add new category'"></h4>
                </div>
                <div class="modal-body">
                    <div v-bind:class="errors.modal && errors.modal.name ? 'form-group has-error' : 'form-group'">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="forms.modal.name">
                        <span class="help-block" v-if="errors.modal && errors.modal.name">
                            <div v-for="error in errors.modal.name">
                                <strong v-text="error"></strong>
                            </div>
                        </span>
                    </div>
                    <div v-if="list.length" v-bind:class="errors.modal && errors.modal.procreator_id ? 'form-group has-error' : 'form-group'">
                        <label>Parent</label>
                        <select class="form-control" v-model="forms.modal.procreator_id">
                            <option value="">-- Without parent --</option>
                            <option v-for="category in list" 
                                    v-bind:value="category.id" 
                                    v-text="category.name" 
                                    v-if="forms.modal.id != category.id"></option>
                        </select>
                        <span class="help-block" v-if="errors.modal && errors.modal.procreator_id">
                            <div v-for="error in errors.modal.procreator_id">
                                <strong v-text="error"></strong>
                            </div>
                        </span>
                    </div>
                    <div v-bind:class="errors.modal && errors.modal.enabled ? 'form-group has-error' : 'form-group'">
                        <label>
                            <input type="checkbox" v-model="forms.modal.enabled">
                            Enabled <small>(This option is responsible for displaying the category on the site)</small>
                        </label>
                        <span class="help-block" v-if="errors.modal && errors.modal.enabled">
                            <div v-for="error in errors.modal.enabled">
                                <strong v-text="error"></strong>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="ladda-button btn btn-primary" data-style="expand-right" v-on:click="update($event)">Create</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
