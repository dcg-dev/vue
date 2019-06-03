@extends('admin.layouts.main')
@section('title', $item->name)
@section('breadcrumb')
<li><a href="{{route('admin.item.list')}}">Item List</a></li>
<li><strong>{{$item->name}}</strong></li>
@endsection
@section('page-navigation')
@endsection
@section('content')
<div id="admin-item-edit" data-id="{{$item->slug}}">
    @include('admin.item.partials.form')
</div>
@endsection
