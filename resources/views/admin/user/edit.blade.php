@extends('admin.layouts.main')
@section('title', 'Edit User ' . $user->fullname)
@section('content')

<div id="admin-user-edit" data-username="{{ $user->username }}">
    @include('admin.user.partials.form')
</div>

@endsection