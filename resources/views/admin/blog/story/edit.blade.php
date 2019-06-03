@extends('admin.layouts.main')
@section('title', 'Edit Blog Story - ' . $story->title)
@section('content')

<div id="admin-blog-story-edit" data-slug="{{ $story->slug }}">
    @include('admin.blog.story.partials.form')
</div>

@endsection