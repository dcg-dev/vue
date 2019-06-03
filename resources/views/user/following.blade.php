@extends('layouts.main')
@section('title', $user->username . ' - Following')
@section('content')
<div id="user-view" data-id="{{ $user->username }}">
    @include('user.partials.header', ['user' => $user])
    <user-following data-id="{{ $user->username }}" :followed="form.followed"></user-following>
</div>
@endsection