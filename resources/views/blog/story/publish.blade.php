@extends('layouts.main')
@section('content')
<!-- View Component -->
<div class="content content-boxed" id="blog-story-publish" data-id="{{ $story->slug }}">
    <!-- Publish Form -->
        @include('blog.story.partials.publish.form')
    <!-- END Publish Form -->
</div>
<!-- END View Component -->
@endsection