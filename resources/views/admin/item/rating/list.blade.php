@extends('admin.layouts.main')
@section('title', 'Reviews List')
@section('content')
    <div id="admin-review-list">
        <div class="row">
            <div class="col-md-offset-7 col-md-5">
                <div class="pull-right form-group">
                    <input type="text" class="form-control" type="text" placeholder="Type and hit enter.."
                           v-model="search"
                           v-on:keyup.enter="getList()"/>
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
                    <tr v-for="item in collection.getData()">
                        <td>@{{ item.get('review') }}</td>
                        <td>
                            <a v-bind:href="item.get('creator').getEditUrl()"
                               v-text="item.get('creator').get('username')"></a>
                        </td>
                        <td>
                            <a v-bind:href="item.get('item').getEditUrl()">
                                @{{ item.get('item').get('name') }}
                            </a>
                        </td>
                        <td>
                            @{{ item.get('created_at') ? item.get('created_at').format('MMMM DD, YYYY') : '' }}
                        </td>
                        <td>
                            <a v-on:click="edit(item)" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i>
                                Edit </a>
                            <a v-on:click="deleteItem(item)" class="btn btn-white btn-sm">
                                <i class="fa fa-close"></i> Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center" v-if="collection.isEmpty()">
                    <strong>There are no reviews yet.</strong>
                </div>
                <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
            </div>
        </list>
        <div v-if="modal" id="edit-modal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit review</h4>
                    </div>
                    <div class="modal-body">
                        <div v-bind:class="errors.modal.review ? 'form-group has-error' : 'form-group'">
                            <label>Review</label>
                            <textarea class="form-control" v-model="modal.attributes.review"></textarea>
                            <span class="help-block" v-if="errors.modal.review">
                            <div v-for="error in errors.modal.review">
                                <strong v-text="error"></strong>
                            </div>
                        </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="ladda-button btn btn-primary" data-style="expand-right"
                                v-on:click="update($event)">Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
