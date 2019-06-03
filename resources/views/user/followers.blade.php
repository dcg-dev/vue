@extends('layouts.main')
@section('title', $user->username . ' - Followers')
@section('content')
<div id="user-view" data-id="{{ $user->username }}">
    @include('user.partials.header', ['user' => $user])
    <user-followers data-id="{{ $user->username }}" :followed="form.followed"></user-followers>
</div>
<!-- END View component, starts at partials.blade.php -->

@endsection