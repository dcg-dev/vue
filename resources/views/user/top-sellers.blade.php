@extends('layouts.main')
@section('title', 'Top Sellers')
@section('content')
<div id="top-sellers">
    <div class="bg-image" style="background-image: url('{{asset('/images/headers/newsletter-bg.jpg')}}');">
        <div class="content bg-flat-op">
            <div class="content-boxed push-10-t push-15 clearfix">
                <div class="animated fadeIn col-sm-12 push-20-l">
                    <h2 class="h2 text-white animated fadeIn font-w300">Top Sellers</h2>
                    <h5 class="font-w300 text-white-op push-30">These sellers sold the most items</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row content content-boxed push-50 push-30-t">
        <div v-if="!sellers.isEmpty()">
            <sellers-advanced :collection="sellers" v-bind:item-class="'col-sm-6 col-lg-3'"></sellers-advanced>
        </div>
        <div v-if="sellers.isEmpty()" class="m-b-lg text-center empty-collection">
            Sellers not found.
        </div>
        <collection-pagination :collection="sellers" v-on:go="refresh"></collection-pagination>
    </div>
</div>
@endsection