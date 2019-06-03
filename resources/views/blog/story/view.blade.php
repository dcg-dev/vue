@extends('layouts.main')
@section('meta')
<meta property="og:url"           content="{{ route('blog.story.view', ['story' => $story->slug]) }}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{ $story->title }}" />
<meta property="og:description"   content="{{ strip_tags($story->sub_title) }}" />
<meta property="og:image"         content="{{ url($story->image) }}" />
@endsection
@section('content')
<div id="blog-story-view" data-story_id="{{ $story->slug }}">
    <div v-if="story">
        @include('blog.story.partials.view.header')
        <div class="bg-white">
            <section class="content content-boxed">
                <!-- Section Content -->
                <div class="text-center">
                    <div class="block-content text-center overflow-hidden">
                        <div class="push-20-t push-10 animated fadeInDown">
                            <img class="img-avatar img-avatar96 img-avatar-thumb" v-bind:src="story.get('creator').getAvatar()" v-bind:alt="story.get('creator').getFullname()">
                        </div>
                        <a class="link-effect font-s13 font-w600" v-bind:href="story.get('creator').getUrl()" v-text="story.get('creator').getFullname()"></a>
                        <span v-text="' on ' + (story.get('creator').get('created_at') ? story.get('creator').get('created_at').format('MMMM DD, YYYY') : '')"></span>
                    </div>
                </div>
                <div class="row push-50-t push-50 nice-copy-story">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div v-html="story.get('text')"></div>
                        <!-- Comments -->
                        @include('blog.story.partials.view.comments')
                        <!-- END Comments -->
                        <!-- Actions -->
                        <div class="push-50-t clearfix">
                            <div class="pull-right">
                                <span></span>
                                <button v-on:click="likeStory()" 
                                        v-bind:class="'btn btn-' + (story.get('is_liked') ? 'primary' : 'default')"
                                        v-bind:disabled="story.loadingLike">
                                    <i class="fa fa-thumbs-o-up"></i> <span v-text="' Like ' + (story.get('count_likes') ? story.get('count_likes') : '0')"></span>
                                </button>
                                <div class="btn-group dropup">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><i class="fa fa-share-alt"></i> Share</a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li v-on:click.prevent='share("facebook")'>
                                            <a tabindex="-1" href="javascript:void(0)"><i class="fa fa-fw fa-facebook pull-right"></i> Facebook</a>
                                        </li>
                                        <li v-on:click.prevent='share("twitter")'>
                                            <a tabindex="-1" href="javascript:void(0)"><i class="fa fa-fw fa-twitter pull-right"></i> Twitter</a>
                                        </li>
                                        <li v-on:click.prevent='share("google")'>
                                            <a tabindex="-1" href="javascript:void(0)"><i class="fa fa-fw fa-google-plus pull-right"></i> Google+</a>
                                        </li>
                                        <li v-on:click.prevent='share("linkedin")'>
                                            <a tabindex="-1" href="javascript:void(0)"><i class="fa fa-fw fa-linkedin pull-right"></i> LinkedIn</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- END Actions -->
                    </div>
                </div>
                <!-- END Section Content -->
            </section>
        </div>
        <!-- More Stories -->
        @include('blog.story.partials.view.more_stories')
        <!-- END More Stories -->
    </div>
</div>
<!-- END View Component -->
@endsection