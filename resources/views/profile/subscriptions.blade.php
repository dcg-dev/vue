@extends('layouts.main')
@section('title', 'Subscriptions')
@section('subtitle', 'Upgrade your plan anytime')
@section('content')
@include('profile.topbar')
<div class="content content-boxed" id="billing-subscriptions">
    <!-- Stats -->
    <div class="row text-uppercase">
        <div class="col-xs-12 col-sm-12">
            <div class="block-content block-content-full bg-gray-dark text-center">
                @if($currentUser->subscribed('main'))
                <div class="text-white">
                    <div class="h6 push-10 font-w300 text-capitalize text-white-op">Your current plan</div>
                    <div class="h3 font-w600 text-white text-capitalize">{{ $currentUser->getPlan()->name }}</div>
                    <div class="font-s12 font-w400 text-white-op text-capitalize push-10">Commission {{ $currentUser->getPlan()->commission }}%</div>
                </div>
                @endif
                <a href="{{ route('billing.subscription.upgrade') }}"><button class="btn btn-minw btn-rounded btn-success-modern btn-md push-5-t" type="button">Upgrade Your Plan</button></a>

                <div class="form-group push-20">
                    <label class="css-input css-checkbox css-checkbox-success text-white-op font-w300" title="If you disable automatic renewal of subscription, then your items can be deleted after the system does not receive payment.">
                        <input id="renewal_checkbox" type="checkbox" v-bind:checked.prevent="isRenewal('{{ $currentUser->getPlan()->ends_at }}')" v-on:change="setRenewal($event)"><span></span> <span style="text-transform:capitalize;">Automatic renewal</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <!-- END Stats -->

    <billing-invoices></billing-invoices>
 </div>
@endsection