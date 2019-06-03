@extends('layouts.main')
@section('title', 'Community')
@section('subtitle', 'Join our community and grow together')
@section('content')
<!-- Hero Section -->
<div class="bg-img overflow-hidden" style="background-image: url('{{asset('images/headers/coverwall-polygon.jpg')}}');">
    <div class="bg-flat-op">
        <div class="content">
            <div class="block block-transparent block-themed content-boxed text-center">
                <div class="block-content push-10-l">
                    <h2 class="h2 font-w300 text-white animated fadeInDown push-5">Community</h2>
                    <h4 class="h5 font-w400 text-white-op animated fadeInUp">Join our community and grow together</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Hero Section -->

<!-- From The Blog -->
<section class="content content-boxed push-100-t push-100">
    <!-- Forum -->
    <div class="col-lg-4 push-100">
        <a class="block block-link-hover3" href="#">
            <div class="block">
                <div class="bg-image mheight-200" style="background-image: url('/images/headers/header-console.jpg');background-size: cover;"> &nbsp;  </div>
                <div class="block-content block-content-full">
                    <div class="row text-center">
                        <div class="col-xs-12">
                            <div class="h2 font-w300">Forum</div>
                            <div class="h5 text-muted push-5-t">Learn more and discuss</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- END Forum -->


    <!-- Blog -->
    <div class="col-lg-4">
        <a class="block block-link-hover3" href="{{ route('blog.story.list') }}">
            <div class="block">
                <div class="bg-image mheight-200" style="background-image: url('/images/photos/blog.jpg');"> &nbsp;  </div>
                <div class="block-content block-content-full">
                    <div class="row text-center">
                        <div class="col-xs-12">
                            <div class="h2 font-w300">Blog</div>
                            <div class="h5 text-muted push-5-t">Read our latest posts</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- END Blog -->

    <!-- Blog -->
    <div class="col-lg-4">
        <a class="block block-link-hover3" href="{{ route('support.faq.view') }}">
            <div class="block">
                <div class="bg-image mheight-200" style="background-image: url('/images/photos/support.jpg');"> &nbsp;  </div>
                <div class="block-content block-content-full">
                    <div class="row text-center">
                        <div class="col-xs-12">
                            <div class="h2 font-w300">Support</div>
                            <div class="h5 text-muted push-5-t">Learn how to get the most out of our service</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- END Blog -->
</section>
<!-- END From The Blog -->
@endsection
