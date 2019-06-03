@extends('layouts.main')
@section('title', 'Downloads')
@section('subtitle', 'Your purchases')
@section('content')
    @include('profile.topbar')
    <div class="content content-boxed" id="downloads">
        <downloads></downloads>
    </div>
@endsection