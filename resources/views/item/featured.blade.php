@extends('layouts.main')
@section('title',"Featured Items")
@section('content')
    <!-- Page Content -->
    <div class="content remove-padding" id="item-featured">

        <div class="bg-image" style="background-image: url('/images/headers/newsletter-bg.jpg');">
            <div class="content bg-flat-op">
                <div class="content-boxed push-10-t push-15 clearfix">
                    <div class="animated fadeIn col-sm-12 push-20-l">
                        <h2 class="h2 text-white animated fadeIn font-w300">Featured Items <span class="badge badge-info text-w300">new</span></h2>
                        <h5 class="font-w300 text-white-op push-30">The latest selection of items</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Content -->

        <items-featured :collection="items"></items-featured>

        <collection-pagination :collection="items" v-on:go="paginate"></collection-pagination>
    </div>
    <!-- END Main Content -->
</div>
<!-- END Page Content -->
@endsection
