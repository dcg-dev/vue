@extends('admin.layouts.main')
@section('title', 'Countries')
@section('content')
    <div id="admin-country-list">
        <div class="row m-b-md">
            <div class="col-md-12 text-right">
                <button class="btn btn-info" @click="create">Add country</button>
            </div>
        </div>
        <list v-bind:collection="countries">
            <div class="project-list table-responsive">
                <table class="table table-hover" v-if="!countries.isEmpty()">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>VAT</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in countries.getData()">
                        <td>@{{ item.get('name') }}</td>
                        <td>@{{ item.get('vat') }}%</td>
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
                <div class="text-center" v-if="countries.isEmpty()">
                    <strong>There are no countries yet.</strong>
                </div>
                <collection-pagination :collection="countries" v-on:go="page"></collection-pagination>
            </div>
        </list>
        <country-form :model="country" ref="form" @success="refresh"></country-form>
    </div>
@endsection