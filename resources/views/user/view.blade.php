@extends('layouts.main')
@section('title', $user->username)
@section('content')
<div id="user-view" data-id="{{ $user->username }}">
    @include('user.partials.header', ['user' => $user])
    <!-- Main Content -->
    <div class="row content content-boxed">
        <div class="col-sm-5 col-sm-push-7 col-lg-4 col-lg-push-8">
            <!-- Buttons -->
            <user-buttons :id="id" :current="current_id" :form="form" :guest="isGuest"></user-buttons>
            <!-- END Buttons -->

            <!-- Freelance -->
            <user-freelance :form="form"></user-freelance>
            <!-- END Freelance -->

            <!-- Country -->
            <user-country :form="form"></user-country>
            <!-- END Country -->

            <!-- Badges -->
            <user-badges :form="form"></user-badges>
            <!-- END Badges -->

            <!-- Skills -->
            <user-skills :form="form"></user-skills>
            <!-- END Skills -->

            <!-- Followers -->
            <div id="list-followers" class="block block-opt-refresh-icon6">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button v-on:click="refresh('followers', $event)" type="button"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h4 class="font-w300 text-muted"><i class="si si-user-following text-muted"></i> Followers</h4>
                </div>
                <user-latest-followers :form="form" route="{{ route('user.followers', ['username' => $user->username]) }}"></user-latest-followers>
            </div>
            <!-- END Followers -->

            <!-- Products -->
            <div id="list-items" class="block block-opt-refresh-icon6">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button v-on:click="refresh('items', $event)" type="button"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h4 class="font-w300 text-capitalize text-muted"><i class="si si-fw si-briefcase text-muted"></i> Latest Items</h4>
                </div>
                <user-latest-items :form="form" route="{{ route('user.items', ['username' => $user->username]) }}"></user-latest-items>
            </div>
            <!-- END Products -->

            <!-- Ratings -->
            <div id="list-ratings" class="block block-opt-refresh-icon6">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button v-on:click="refresh('ratings', $event)" type="button"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h4 class="text-muted font-w300"><i class="fa fa-fw fa-star-o"></i> Ratings</h4>
                </div>
                <user-latest-ratings :form="form" route="{{ route('user.ratings', ['username' => $user->username]) }}"></user-latest-ratings>
            </div>
            <!-- END Ratings -->
        </div>
        <div class="col-sm-7 col-sm-pull-5 col-lg-8 col-lg-pull-4">
            <!-- About -->
            <div class="block">
                <div class="block-content">
                    <p class="text-muted" v-html="form.biography ? form.biography : 'This user has no description yet.'"></p>
                </div>
            </div>
            <!-- END About -->
        </div>
    </div>
    <!-- END Main Content -->

</div>
<!-- END View component, starts at partials.blade.php -->

@endsection