@extends('layouts.main')
@section('title', 'Notifications')
@section('subtitle', 'Your latest notifications')
@section('content')
@include('profile.topbar')
<div class="content content-boxed" id="profile-notifications">
    <div class="col-sm-6 col-lg-3 bg-gray-lighter block-content">
        <button v-on:click="toggleDialog($event)" class="btn btn-lg btn-success-modern btn-block push-30 push-10-t h4 font-w300">Delete All Notifications</button>
        <h4 class="push-10">Notifications</h4>
        <p class="push-30">Notifications tell you about everything important that's happening within your account. They get automatically deleted once you have read them. You can also delete all notifications</p>
    </div>
    <div class="block col-sm-6 col-lg-9 push"  v-if="!notifications.isEmpty()">
        <div class="block-content">
            <ul class="list list-activity push">
                <li v-for="notification in notifications.getData()">
                    <i v-bind:class="('si si-' + notification.getInfo().icon) + (' text-' + notification.getInfo().color)"></i>
                    <div class="font-w600" v-text="notification.getInfo().text"></div>
                    <div><a v-bind:href="notification.getInfo().url" v-text="notification.getInfo().urlText"></a></div>
                    <div v-if="typeof notification.getInfo().subText !== 'undefined'"><span v-text="notification.getInfo().subText"></span></div>
                    <div><small class="text-muted" v-text="notification.get('created_at').fromNow()"></small></div>
                </li>
            </ul>
            <!-- Pagination -->
            <div class="text-center">
                <nav>
                    <pagination v-bind:pagination="pagination" v-if="pagination.total > pagination.to"
                        v-on:click.native="getNotifications(pagination.current_page, pagination.per_page)">
                    </pagination>
                </nav>
            </div>
            <!-- END Pagination -->
        </div>
    </div>
    <div class="block col-sm-6 col-lg-9 push empty-collection" v-else>
        <div class="block-content text-center text-gray">
            <p>There aren't any notifications.</p>
        </div>
    </div>
</div>
@endsection