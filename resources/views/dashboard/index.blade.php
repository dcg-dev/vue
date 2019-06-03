@extends('layouts.main')
@section('content')
<div id="dashboard" data-items_pagination="{{ $itemsPagination }}" 
                    data-popular_pagination="{{ $popularPagination }}" 
                    data-featured_pagination="{{ $featuredPagination }}" 
                    data-stories_pagination="{{ $storiesPagination }}"
                    data-sellers_pagination="{{ $sellersPagination }}">
    @include('dashboard.partials.search')
    @include('dashboard.partials.marketplace')
    @include('dashboard.partials.blog')
    @include('dashboard.partials.banner')
    @include('dashboard.partials.newsletter')
</div>
@endsection
