@extends('admin.layouts.main')
@section('title', 'Plans')
@section('content')
<div id="admin-plan-list">
    <div class="row m-b-md">
        <div class="col-md-12 text-right">
            <button class="btn btn-info" v-on:click="newPlan">Create new Plan</button>
        </div>
    </div>
    <list v-bind:collection="collection">
    <div class="project-list table-responsive">
        <table class="table table-hover" v-if="!collection.isEmpty()">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="plan in collection.getData()">
                    <td>@{{ plan.get('stripe_id') }}</td>
                    <td>@{{ plan.get('name') }}</td>
                    <td>
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
            <strong>There are no plans yet.</strong>
        </div>
        <collection-pagination :collection="collection" v-on:go="page"></collection-pagination>
    </div>
    </list>
    <plan v-bind:plan="plan" id="plan-modal" v-on:success="refresh"></plan>
</div>
@endsection
