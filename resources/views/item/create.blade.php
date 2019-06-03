@extends('layouts.main')
@section('title', 'Upload New Item')
@section('subtitle', 'Sell your work worldwide')
@section('content')
    @include('profile.topbar')
    <div class="content content-boxed" id="item-create">
        <div class="block">
            @include('item.partials.form')
        </div>
        <modal-edit-profile :user="currentUser" ref="modalProfile" @done="submit"></modal-edit-profile>
    </div>
@endsection
