@extends('layouts.main')
@section('title', 'Blog')
@section('subtitle', 'Explore the latest stories.')
@section('meta')
<meta property="og:url" />
<meta property="og:type" />
<meta property="og:title" />
<meta property="og:description" />
<meta property="og:image" />
@endsection
@section('content')
@include('blog.story.partials.list.header')
<section class="content content-boxed" id="blog-story-list">
    <!-- Section Content -->
    <div class="push-20-t push-50">
        <div class="row">
            <div class="col-md-8" v-if="!stories.isEmpty()">
                <!-- Story -->
                <div class="block" v-for="story in stories.getData()">
                    <div class="block-content">
                        <div class="row items-push">
                            <div class="col-md-4">
                                <a v-bind:href="story.getUrl()">
                                    <img class="img-responsive" v-bind:src="story.get('image')" v-bind:alt="story.get('title')">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <div class="font-s12 push-10">
                                    <!-- <em class="pull-right">10 min</em>-->
                                    <a v-bind:href="story.get('creator').getUrl()" v-text="story.get('creator').getFullname()"></a><span v-text="' on ' + story.get('created_at').format('MMMM DD, YYYY')"></span>
                                </div>
                                <h4 class="h3 font-w300 push-10"><a class="text-primary-dark" v-bind:href="story.getUrl()" v-text="story.get('title')"></a></h4>
                                <p class="push-20">@{{ story.get('text') | truncate }}</p>
                                <div class="btn-group btn-group-sm">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><i class="fa fa-share-alt push-5-r"></i> Share</a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li v-on:click.prevent='share("facebook", story)'>
                                            <a tabindex="-1" href="javascript:void(0)"><i class="fa fa-fw fa-facebook pull-right"></i> Facebook</a>
                                        </li>
                                        <li v-on:click.prevent='share("twitter", story)'>
                                            <a tabindex="-1" href="javascript:void(0)"><i class="fa fa-fw fa-twitter pull-right"></i> Twitter</a>
                                        </li>
                                        <li v-on:click.prevent='share("google", story)'>
                                            <a tabindex="-1" href="javascript:void(0)"><i class="fa fa-fw fa-google-plus pull-right"></i> Google+</a>
                                        </li>
                                        <li v-on:click.prevent='share("linkedin", story)'>
                                            <a tabindex="-1" href="javascript:void(0)"><i class="fa fa-fw fa-linkedin pull-right"></i> LinkedIn</a>
                                        </li>
                                    </ul>
                                    <a class="btn btn-default" v-bind:href="story.getUrl()">Continue Reading..</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Story -->
                <!-- Pagination -->
                <nav>
                    <collection-pagination :collection="stories" v-on:go="page" :history="false"></collection-pagination>
                </nav>
                <!-- END Pagination -->
            </div>
            <div class="col-md-8" v-else>
                <div class="block">
                    <div class="block-content">
                        <p>There are no stories yes.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Search -->
                @include('blog.story.partials.list.search')
                <!-- END Search -->
                
                <!-- About -->
                @include('blog.story.partials.list.about')
                <!-- END About -->
                
                <!-- Top Stories -->
                @include('blog.story.partials.list.top_stories')
                <!-- END Top Stories -->

                <!-- Social -->
                @include('blog.story.partials.list.social')
                <!-- END Social -->
            </div>
        </div>
    </div>
    <!-- END Section Content -->
</section>
@endsection