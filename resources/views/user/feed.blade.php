@extends('layouts.main')
@section('title', 'Follow Feed')
@section('content')
<div id="user-feed">
    <div class="bg-img overflow-hidden" style="background-image: url('{{asset('/images/headers/coverwall-polygon.jpg')}}');">
        <div class="bg-flat-op">
            <div class="content">
                <div class="block block-transparent block-themed content-boxed text-left">
                    <div class="block-content push-10-l">
                        <h2 class="h2 font-w300 text-white animated fadeInDown push-5">Follow Feed</h2>
                        <h4 class="h5 font-w400 text-white-op animated fadeInUp">Fresh items from sellers and collections you like</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-lighter">
        <section class="content content-boxed">
            <div class="row">
                <div class="col-lg-3">
                    <!-- Buttons which toggles side nav content content in smaller screens -->
                    <!-- Toggle class helper (for .js-nav-content below), functionality initialized in App() -> uiToggleClass() -->
                    <div class="block hidden-lg">
                        <div class="block-content">
                            <button class="btn btn-sm btn-block btn-default push" type="button" data-toggle="class-toggle" data-target=".js-nav-content" data-class="visible-lg">
                                <i class="fa fa-list-ul push-5-r"></i> Navigation
                            </button>
                        </div>
                    </div>

                    <!-- Side Content -->
                    <div class="js-nav-content visible-lg">
                        <!-- Categories -->
                        <div class="block" v-if="!categories.isEmpty()">
                            <div class="block-content">
                                <ul class="nav nav-pills nav-stacked push">
                                    <li v-for="category in categories.getData()">
                                        <a href="#" :class="'h3 '+(filters.category == category.get('id') ? 'active' : '')" v-on:click.prevent="filter('category', category.get('id'))">
                                            <span class="badge pull-right" v-text="category.get('count', 0)"></span>
                                            <span v-text="category.get('name')"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="block" v-if="!currentUser.get('following').isEmpty()">
                            <a  v-for="user in currentUser.get('following').getData()" class="block block-link-hover3 block-transparent remove-margin-b" v-bind:href="user.getUrl()">
                                <div class="block-content block-content-full clearfix">
                                    <div class="pull-right">
                                        <img class="img-avatar" v-bind:src="user.get('avatar')" alt="">
                                    </div>
                                    <div class="pull-left push-10-t">
                                        <div class="font-w600 push-5" v-text="user.getFullname()"></div>
                                        <div class="text-muted"><span v-text="user.get('count_followers',0)"></span> Follower</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <list-advance v-bind:collection="collection" empty-text="Not items yet. Follow collections or authors." v-on:refresh="refresh"></list-advance>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection