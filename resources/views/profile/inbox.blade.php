@extends('layouts.main')
@section('title', 'Inbox')
@section('subtitle', 'Your messages')
@section('content')
@include('profile.topbar')
<div class="content content-boxed" id="inbox">
    <!-- Inbox Content -->
    <div class="row">
        <div class="col-sm-5 col-lg-3">
            @include('profile.partials.sidebar')
        </div>
        <div class="col-sm-7 col-lg-9">
            <inbox-list :threads="threads" v-on:refresh="refresh" :current="currentSection" :loading="loading" :user="{{ $currentUser->id }}" v-on:go="paginate"></inbox-list>
        </div>
    </div>
</div>
@stop