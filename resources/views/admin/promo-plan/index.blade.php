@extends('admin.layouts.main')
@section('title', 'Promotional')
@section('content')
    <div id="admin-plan-promotional" data-blog_price="{{ Setting::get('blog.price') }}" data-config_route="{{ route('admin.settings.store') }}">
        <div class="row m-b-md">
            <div class="col-md-6">
                <button class="btn btn-info" v-on:click="newPlan">Create new Promotional Plan</button>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-primary" v-on:click="saveConfiguration">Save Configuration</button>
            </div>
        </div>
        <div class="row m-b-md">
            <div class="col-md-6">
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
                            <tr v-for="plan in collection.getData()">
                                <td>@{{ plan.get('name') }}</td>
                                <td class="text-right">
                                    <a href="#" class="btn btn-white btn-sm" v-on:click.prevent="editPlan(plan)">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                    <a href="#" class="btn btn-white btn-sm" v-on:click.prevent="deletePlan(plan)">
                                        <i class="fa fa-close"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="text-center" v-if="collection.isEmpty()">
                            <strong>There are no promotional plans yet.</strong>
                        </div>
                        <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
                    </div>
                </list>
                <promo-plan v-bind:plan="plan" id="plan-modal" v-on:success="refresh"></promo-plan>
            </div>
            <div class="col-md-6">
                <div class="ibox float-e-margins" v-bind:style="collection.isEmpty() ? '' : 'margin-top: 36px;'">
                    <div class="ibox-title">
                        <h5>General Blog</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <label>Story Price</label>
                            <input type="text" name="blog_price" class="form-control" v-model="blogPrice">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection