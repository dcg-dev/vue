@extends('layouts.main')
@section('title', $user->username . ' - Items')
@section('content')
<div id="user-view" data-id="{{ $user->username }}">
    @include('user.partials.header', ['user' => $user])
    <user-items data-id="{{ $user->username }}"></user-items>
</div>
@endsection