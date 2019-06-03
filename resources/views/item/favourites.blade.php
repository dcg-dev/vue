@extends('layouts.main')
@section('title', 'Favourites')
@section('subtitle', 'Items that you bookmarked')
@section('content')
@include('profile.topbar')
<div class="content content-boxed" id="item-favourites">
    <div v-if="!collection.isEmpty()">
        <items :collection="collection" child="item"></items>
        <collection-pagination :collection="collection" v-on:go="paginate"></collection-pagination>
    </div>
    <div v-if="collection.isEmpty()" class="text-center text-gray push">
        You don't have favourites items.
    </div>
</div>
@endsection
