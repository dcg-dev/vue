@extends('layouts.main')
@section('title', 'Support')
@section('subtitle', 'Need help?')
@section('content')
@include('support.ticket.partials.topbar')
<div class="content content-boxed" id="support-ticket-view" data-id="{{ $ticket->id }}">
   <!-- Discussion Block -->
    <div v-bind:class="'block' + (loading ? ' block-opt-refresh' : '')">
        <div class="block-header bg-gray-lighter">
            <ul class="block-options">
                <li>
                    <button type="button" v-on:click="getTicket"><i class="si si-refresh"></i></button>
                </li>
            </ul>
            <a href="{{ route('support.ticket.list') }}"><span class="text-muted h4"><i class="si si-action-undo"></i> Back</span></a>
        </div>
        <div class="block-content" v-if="ticket && currentUser">
            <!-- Discussion -->
            <div class="text-center">
                <p><strong v-html="ticket.get('subject')"></strong></p>
                <p><i v-html="ticket.get('description')"></i></p>
            </div>
            <table class="table table-striped table-borderless" v-if="!ticket.get('posts').isEmpty()">
                <tbody>
                    <template v-for="post in ticket.get('posts').getData()">
                        <tr>
                            <td class="hidden-xs"></td>
                            <td class="font-s13 text-muted">
                                <a v-bind:href="post.checkIsAdmin(currentUser.get('id')) ? '#' : post.get('user').getUrl()"
                                   v-text="post.get('user').getFullname()"></a>
                                <span v-text="post.get('created_at') ? (' on ' + post.get('created_at').format('MMMM DD, YYYY - HH:mm')) : ''"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center hidden-xs" style="width: 140px;">
                                <div class="push-10">
                                    <a v-bind:href="post.checkIsAdmin(currentUser.get('id')) ? '#' : post.get('user').getUrl()">
                                        <img class="img-avatar" v-bind:src="post.get('user').getAvatar()" v-bind:alt="post.get('user').getFullname()">
                                    </a>
                                </div>
                                <label v-bind:class="'label label-' + (post.checkIsAdmin(currentUser.get('id')) ? 'primary' : 'success')"
                                       v-text="post.checkIsAdmin(currentUser.get('id')) ? 'Support' : 'User'"></label>
                            </td>
                            <td v-html="post.get('text')"></td>
                        </tr>
                    </template>
                    <tr v-if="!ticket.isSolved()">
                        <td class="hidden-xs"></td>
                        <td class="font-s13 text-muted">
                            <a v-bind:href="currentUser.getUrl()" v-text="currentUser.getFullname()"></a> Just now
                        </td>
                    </tr>
                    <tr v-if="!ticket.isSolved()">
                        <td class="text-center hidden-xs">
                            <div class="push-10">
                                <a v-bind:href="currentUser.getUrl()">
                                    <img class="img-avatar" v-bind:src="currentUser.getAvatar()" v-bind:alt="currentUser.getFullname()">
                                </a>
                            </div>
                        </td>
                        <td>
                            <ckeditor :value.sync="post" @blur="value => post = value"  ref="editor"></ckeditor>
                            <br>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="btn btn-sm btn-primary" v-on:click="reply($event)"><i class="fa fa-reply"></i> Reply</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- END Discussion -->
        </div>
    </div>
    <!-- END Discussion Block -->
</div>
@endsection