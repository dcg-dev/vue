@extends('admin.layouts.main')
@section('title', 'Licenses')
@section('content')
    <div id="admin-license-list">
        <div class="row m-b-md">
            <div class="col-md-12 text-right">
                <button class="btn btn-info" v-on:click="showCreate">Create new License</button>
            </div>
        </div>
        <draggable @end="move"  class="draggable">
            <transition-group>
                <div class="three-item" v-for="element in list" :key="element.index" v-bind:data-id="element.id">
                    <div class="vote-item">
                        <div class="row">
                            <div class="col-md-8">
                                <a href="#" class="vote-title">
                                    <i class="fa fa-lg fa-arrows text-danger"> </i> <span v-text="element.name"></span>
                                    <small class="text-danger" v-if="!element.enabled">Disabled</small>
                                </a>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="#" class="btn btn-white btn-sm" v-on:click.prevent="showEdit(element)">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a href="#" class="btn btn-white btn-sm" v-on:click.prevent="remove(element)">
                                    <i class="fa fa-close"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </transition-group>
        </draggable>
        <div id="license-modal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" v-text="(forms.modal.id) ? 'Edit '+forms.modal.name+' License' : 'Create new License'"></h4>
                    </div>
                    <div class="modal-body">
                        <div v-bind:class="errors.modal.name ? 'form-group has-error' : 'form-group'">
                            <label>Name</label>
                            <input type="text" class="form-control" v-model="forms.modal.name">
                            <span class="help-block" v-if="errors.modal.name">
                            <div v-for="error in errors.modal.name">
                                <strong v-text="error"></strong>
                            </div>
                        </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.modal.slug ? ' has-error' : '')">
                            <label>Slug</label>
                            <input disabled v-model="forms.modal.slug" type="text" class="form-control">
                            <span class="help-block" v-if="errors.modal.slug">
                            <div v-for="error in errors.modal.slug"><strong v-text="error"></strong></div>
                        </span>
                        </div>
                        <div v-bind:class="errors.modal.coefficient ? 'form-group has-error' : 'form-group'">
                            <label>Coefficient</label>
                            <input type="number" class="form-control" v-model="forms.modal.coefficient">
                            <span class="help-block" v-if="errors.modal.coefficient">
                            <div v-for="error in errors.modal.coefficient">
                                <strong v-text="error"></strong>
                            </div>
                        </span>
                        </div>
                        <div v-bind:class="errors.modal.description ? 'form-group has-error' : 'form-group'">
                            <label>Description</label>
                            <textarea class="form-control" v-model="forms.modal.description" rows="5"></textarea>
                            <span class="help-block" v-if="errors.modal.description">
                            <div v-for="error in errors.modal.description">
                                <strong v-text="error"></strong>
                            </div>
                        </span>
                        </div>
                        <div v-bind:class="errors.modal.enabled ? 'form-group has-error' : 'form-group'">
                            <label>
                                <input type="checkbox" v-model="forms.modal.enabled">
                                Enabled <small>(This option is responsible for displaying the license on the site)</small>
                            </label>
                            <span class="help-block" v-if="errors.modal.enabled">
                            <div v-for="error in errors.modal.enabled">
                                <strong v-text="error"></strong>
                            </div>
                        </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="ladda-button btn btn-primary" data-style="expand-right" v-on:click="update($event)">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection