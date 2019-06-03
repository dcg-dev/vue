@extends('layouts.main')
@section('title', $user->username . ' - Collections')
@section('content')
    <div id="user-view" data-id="{{ $user->username }}">
        @include('user.partials.header', ['user' => $user])
    </div>

    <div id="user-collections" class="row content content-boxed" data-id="{{ $user->username }}">
        <div class="row">
            <div class="col-sm-6 col-lg-3 bg-gray-lighter block-content">
                <new-collection-button :author="isAuthor"></new-collection-button>
                <!--            <a href="#" v-if="isAuthor" class="btn btn-lg btn-success-modern btn-block push-30 push-10-t h4 font-w400"  type="button" v-on:click.prevent="modal()">New Collection</a>-->
                <h4 class="push-10">What are collections?</h4>
                <p>Collections are great to share your finds with others. You can create a collection of items you
                    like.</p>
                <p class="push-30">You can either set a collection to 'private' for personal use or set it to 'public'.
                    Public collections appear here and can be liked by others. If others like your taste and selection
                    your profile can get noticed much more.</p>
            </div>
            <div class="col-sm-6 col-lg-9">
                <div v-if="!collections.isEmpty()">
                    <collections v-bind:collection="collections" v-on:delete="refresh"></collections>
                </div>
                <div v-if="collections.isEmpty()" class="m-b-lg text-center">
                    <div v-if="isAuthor">
                        <div>
                            You don't have any collections.
                        </div>
                        <a href="#" class="btn btn-link btn-sm" v-on:click.prevent="modal()">Do you want to create a new
                            collection?</a>
                    </div>
                    <div v-if="!isAuthor">
                        User does not have any collections yet.
                    </div>
                </div>
                <collection-pagination :collection="collections" v-on:go="refresh"></collection-pagination>
            </div>
        </div>
        <collection-create id="modal-collection" v-on:create="refresh"></collection-create>
    </div>
@endsection