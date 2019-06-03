@extends('layouts.main')
@section('title', 'Our company')
@section('subtitle', 'Learn more about our story')
@section('content')
    <div class="bg-img overflow-hidden" style="background-image: url('{{asset('images/headers/about.jpg')}}');">
        <div class="push-100-t push-100">
            <div class="content">
                <div class="block block-transparent block-themed content-boxed text-center push-100-t push-100">
                    <div class="block-content push-10-l">
                        <h2 class="h2 font-w300 text-white animated fadeInDown push-5">Our company</h2>
                        <h4 class="h5 font-w400 text-white-op animated fadeInUp">Learn more about our
                            story</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white">
        <section class="content content-boxed">
            <!-- Section Content -->
            <div class="row items-push push-20-t nice-copy">
                <div class="col-md-6">
                    <h3 class="h3 font-w300 push-10">Who we are?</h3>
                    <p>We are a start up company based in Zurich, Switzerland. In 2006 we wrote music for artists and created sample packs. We realized that there was nothing that helped music producers to earn from their craft. Some of them had hundreds of songs or tracks or sounds lying around unused. So we came up with the idea to help music producers and creatives to earn money by sharing their art with the world. </p>
                    <h3 class="h3 font-w300 push-10 push-10">What can you do for me?</h3>
                    <p>We help music producers, sound designers and vocalists to earn money from their sounds and do more of what they love. We also help producers, singers and youtubers to find the right tunes for their next project. </p>
                    <h3 class="h3 font-w300 push-10">Why should I work with you ?</h3>
                    <p>Look at our platform and you will see why. We provide you all the tools to earn money and even build a solid business from your music. From famous producers to hits in the charts - via our platform we have contributed sounds to countless major projects. So join our community and start selling or get the selected sounds you need.</p>
                </div>
                <div class="col-md-6">
                    <!-- Company Timeline -->
                    <div class="block block-transparent">
                        <div class="block-content">
                            <ul class="list list-timeline pull-t">
                                <li class="visibility-hidden" data-toggle="appear" data-class="animated fadeInRight">
                                    <div class="list-timeline-time">2008</div>
                                    <i class="si si-bulb list-timeline-icon bg-warning"></i>
                                    <div class="list-timeline-content">
                                        <p class="font-w600">The idea was born!</p>
                                        <p class="font-s13">Well, it actually was born years before but not brought to life.</p>
                                    </div>
                                </li>
                                <li class="visibility-hidden" data-toggle="appear" data-timeout="100" data-class="animated fadeInRight">
                                    <div class="list-timeline-time">2009</div>
                                    <i class="si si-speedometer list-timeline-icon bg-city"></i>
                                    <div class="list-timeline-content">
                                        <p class="font-w600">Start Up time!</p>
                                        <p class="font-s13">Thousands of hours of work. Trial and error.</p>
                                    </div>
                                </li>
                                <li class="visibility-hidden" data-toggle="appear" data-timeout="200" data-class="animated fadeInRight">
                                    <div class="list-timeline-time">2011</div>
                                    <i class="si si-briefcase list-timeline-icon bg-smooth"></i>
                                    <div class="list-timeline-content">
                                        <p class="font-w600">First 7'500 users joined!</p>
                                        <p class="font-s13">Amazing times! Our 500 items.</p>
                                    </div>
                                </li>
                                <li class="visibility-hidden" data-toggle="appear" data-timeout="400" data-class="animated fadeInRight">
                                    <div class="list-timeline-time">2016</div>
                                    <i class="si si-like list-timeline-icon bg-primary"></i>
                                    <div class="list-timeline-content">
                                        <p class="font-w600">We continue strong!</p>
                                        <p class="font-s13">Reaching over 20'000 users and over 1'500 items.</p>
                                    </div>
                                </li>
                                <li class="visibility-hidden" data-toggle="appear" data-timeout="400" data-class="animated fadeInRight">
                                    <div class="list-timeline-time">2017</div>
                                    <i class="si si-rocket list-timeline-icon bg-success"></i>
                                    <div class="list-timeline-content">
                                        <p class="font-w600">Launch new platform</p>
                                        <p class="font-s13">We thought of every possible way to offer you the best platform. With your support we will continue to expand the features and bring you even more tools.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END Company Timeline -->
                </div>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
    @include('page.sselling')
@endsection
