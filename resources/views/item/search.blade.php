@extends('layouts.main')
@section('title', $category ? $category->name : "Search items")
@section('content')
    <div id="item-search" data-category="{{$category ? $category->id : false}}">
        <div class="bg-img overflow-hidden"
             style="background-image: url('{{asset('/images/headers/newsletter-bg.jpg')}}');">
            <div class="">
                <section class="content content-full content-boxed">
                    <!-- Section Content -->
                    <div class="push-30-t text-center">
                        <h3 class="h3 text-white-op push-30 animated fadeInDown" data-toggle="appear"
                            data-class="animated fadeInDown">
                            <span v-text="(currentCategory && currentCategory.get('id')) ? currentCategory.get('name') : getOrderTitle()"></span>
                            <span v-if="tags && filters.tags && filters.tags[0]">
                                Tags:
                                <span v-for="(tag_id, key) in filters.tags">
                                    @{{ tags.find(tag_id).get('name') }}@{{ filters.tags.length > key + 1 ? ',' : '' }}
                                </span>
                            </span>
                        </h3>
                        <form method="post" v-on:submit.prevent="refresh">
                            <div class="input-group input-group-lg col-md-6 col-md-offset-3">
                                <input class="form-control" placeholder="Search..." type="text" v-model="filters.q">
                                <div class="input-group-btn">
                                    <button class="btn btn-success-modern"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <h5 class="h5 text-white-op push-10-t push-10 visibility-hidden" data-toggle="appear"
                            data-class="animated fadeInDown"><span v-text="items.total"></span> items found<i
                                    v-text="filters.q ? (' for ' + filters.q) : ''"></i></h5>
                    </div>
                    <!-- END Section Content -->
                </section>
            </div>
        </div>
        <div class="bg-gray-lighter">
            <section class="content content-boxed">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Search Filters -->
                        <div class="block collapse in" id="filter">
                            <div class="block-content form-horizontal">
                                <button class="btn btn-sm btn-block btn-outline hidden-lg push" type="button"
                                        data-toggle="class-toggle" data-target=".js-search-filters"
                                        data-class="visible-lg">
                                    <i class="fa fa-filter push-5-r"></i> Search Filters
                                </button>
                                <p class="text-center text-gray" v-if="currentCategory && currentCategory.get('id')">
                                    <span v-text="items.total"></span> products in
                                    <mark class="font-w600 text-gray-dark" v-text="currentCategory.get('name')"></mark>
                                </p>
                                <div v-if="!categories.isEmpty()">
                                    <h5 class="font-w400 text-gray-darker push-30-t push-20">Categories</h5>
                                    <div class="form-group">
                                        <div class="col-xs-12" v-for="category in categories.getData()">
                                            <label class="css-input css-checkbox css-checkbox-primary">
                                                <input type="checkbox" v:bind:checked="hasCategory(category.get('id'))"
                                                       v-on:click="toggleCategory(category.get('id'), $event)">
                                                <span></span>
                                                <span v-text="category.get('name')"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="font-w400 text-gray-darker push-30-t push-20">Price Range</h5>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input id="price-slider" type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- END Filters Content -->
                                <h5 class="font-w400 text-gray-darker">Formats</h5>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <select2 class="form-control" v-model="filters.formats" multiple
                                                     v-if="!formats.isEmpty()" v-on:input="refresh">
                                                <option v-for="format in formats.getData()"
                                                        v-bind:value="format.get('id')"
                                                        v-text="format.get('name')"></option>
                                            </select2>
                                        </div>
                                    </div>
                                </div>


                                <h5 class="font-w400 text-gray-darker push-30-t push-20">Rating</h5>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <select v-model="filters.rating" class="form-control" size="1"
                                                v-on:change="refresh">
                                            <option value="">All Ratings</option>
                                            <option value="5">5 Stars</option>
                                            <option value="4">4 Stars</option>
                                            <option value="3">3 Stars</option>
                                            <option value="2">2 Stars</option>
                                            <option value="1">1 Stars</option>
                                            <option value="0">0 Stars</option>
                                        </select>
                                    </div>
                                </div>


                                <h5 class="font-w400 text-gray-darker push-30-t">Additional Tags</h5>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <select2 class="form-control" v-model="filters.tags" multiple
                                                     v-if="!tags.isEmpty()" v-on:input="refresh">
                                                <option v-for="tag in tags.getData()" v-bind:value="tag.get('id')"
                                                        v-text="tag.get('name')"></option>
                                            </select2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center hidden-md hidden-lg">
                            <button data-toggle="collapse" data-target="#filter" class="btn btn-success-modern m-b-md">
                                Filters
                            </button>
                        </div>
                        <!-- END Search Filters -->
                    </div>
                    <div class="col-md-9">
                        <list-advance v-bind:collection="items" v-on:refresh="refresh"></list-advance>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
