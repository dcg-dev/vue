@extends('layouts.main')
@section('title', $user->username . ' - Ratings')
@section('content')
<div id="user-view" data-id="{{ $user->username }}">
    @include('user.partials.header', ['user' => $user])
    <user-ratings data-id="{{ $user->username }}"></user-ratings>
</div>
@endsection