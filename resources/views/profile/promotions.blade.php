@extends('layouts.main')
@section('title', 'Promotions')
@section('subtitle', 'Improve your sales performance')
@section('content')
@include('profile.topbar')
<div class="content content-boxed overflow-hidden" id="billing-promotions">
    <promo-plans secret="{{ config('services.stripe.key') }}"></promo-plans>

    <!-- Extra Promotions -->
    <blog-promote secret="{{ config('services.stripe.key') }}" price="{{ config('services.blog.price') }}" route="{{ route('support.faq.view') }}" :user="currentUser"></blog-promote>
    <!-- END Extra Promotions -->
 </div>
@endsection