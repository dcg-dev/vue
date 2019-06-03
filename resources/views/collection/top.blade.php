@extends('layouts.main')
@section('title', 'Top Collections')
@section('content')
<div id="top-collections">
    <div class="bg-image" style="background-image: url('{{asset('/images/headers/newsletter-bg.jpg')}}');">
        <div class="content bg-flat-op">
            <div class="content-boxed push-10-t push-15 clearfix">
                <div class="animated fadeIn col-sm-12 push-20-l">
                    <h2 class="h2 text-white animated fadeIn font-w300">Top Collections <span class="badge badge-info text-w300">new</span></h2>
                    <h5 class="font-w300 text-white-op push-30">Collections people like the most</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row content content-boxed push-50 push-30-t">
        <div v-if="!collections.isEmpty()">
            <collections v-bind:collection="collections" v-bind:item-class="'col-sm-6 col-lg-3'" v-on:delete="refresh"></collections>
        </div>
        <div v-if="collections.isEmpty()" class="m-b-lg text-center">
            Collections not found.
        </div>
        <collection-pagination :collection="collections" v-on:go="refresh"></collection-pagination>
    </div>
</div>
@endsection