@extends('layouts.main')
@section('title', 'Support')
@section('subtitle', 'We are always glad to help you!')
@section('content')
@include('support.ticket.partials.topbar')
<div class="content content-boxed push-30" id="support-ticket-list"> 
    <!-- Categories Block -->
    <div v-bind:class="'block' + (loading ? ' block-opt-refresh' : '')">
        <div class="block-header bg-gray-lighter push-20">
            <ul class="block-options">
                <li>
                    <button v-on:click="getTickets" type="button"><i class="si si-refresh"></i></button>
                </li>
            </ul>
            <span class="h4 font-w300">Support</span>
        </div>
        <div class="block-content block-content-full">
            <div class="btn btn-s btn-success-modern btn-outline push-10 text-right" v-on:click="openCreateModal">
                <i class="fa fa-plus push-5-r"></i>Create New Ticket
            </div>
            <!-- Support Category -->
            <table class="table table-striped table-borderless table-vcenter" v-if="!tickets.isEmpty()">
                <thead>
                    <tr>
                        <th colspan="2">Topic</th>
                        <th class="text-center hidden-xs hidden-sm" style="width: 100px;">Status</th>
                        <th class="text-center hidden-xs hidden-sm" style="width: 100px;">Posts</th>
                        <th class="hidden-xs hidden-sm" style="width: 200px;">Last Post</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="ticket in tickets.getData()">
                        <td>
                           <i v-bind:class="'si si-' + (ticket.isSolved() ? 'check text-muted' : 'question text-success-modern') + ' fa-2x'"></i>
                        </td>
                        <td>
                            <h4 class="h5 font-w600 push-5">
                                <a v-bind:href="ticket.getViewUrl()" v-text="ticket.get('subject')"></a>
                            </h4>
                            <div class="font-s13 text-muted" v-text="ticket.getTruncateDescription()"></div>
                        </td>
                        <td class="text-center hidden-xs hidden-sm">
                            <label v-bind:class="'label label-' + (ticket.isSolved() ? 'default' : 'success-modern') + ' label-outline'" 
                                   v-text="ticket.isSolved() ? 'Solved' : 'Open'"></label>
                        </td>
                        <td class="text-center hidden-xs hidden-sm">
                            <a class="font-w600" href="javascript:void(0)" v-text="ticket.get('countPosts')"></a>
                        </td>
                        <td class="hidden-xs hidden-sm">
                            <span class="font-s13" v-if="ticket.getLastPostUser()">by <a v-bind:href="ticket.getViewUrl()" v-text="ticket.getLastPostUser().getFullname()"></a>
                                <br><span v-text="ticket.getLastPost().get('created_at') ? ticket.getLastPost().get('created_at').format('MMMM DD, YYYY') : ''"></span>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center empty-collection" v-else>
                <p >There aren't any tickets.</p>
            </div>
            <!-- END Support Category -->
        </div>
    </div>
    <!-- END Categories Block -->
    <ticket-create id="modal-create"></ticket-create>
</div>
@endsection