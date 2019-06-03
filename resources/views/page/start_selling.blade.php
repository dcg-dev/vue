@extends('layouts.main')
@section('title', 'Start selling')
@section('content')
<div id="selling-page">
    <div class="bg-white">
        <section class="content content-full content-boxed">
            <!-- Section Content -->
            <div class="push-50-t text-center">
                <h1 class="font-s48 font-w300 text-darkest animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">Start selling with our free plan!</h1>
                <h4 class="h4 font-w400 text-muted animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">Create digital products and music that music producers and creatives love and grow step by step.</h4>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
    <div style="background-image:url('{{asset('images/headers/paperplanes.jpg')}}')">
        <section class="content content-boxed overflow-hidden">
            <span class="push-100-l animated fadeInRight">
                <img src="{{asset('images/photos/mockup.png')}}" alt="" border="0" width="1000" height="623" align="center"></span>
            <div class="bg-white">
                <section class="content content-boxed">
                    <!-- Section Content -->
                    <div class="row items-push-3x push-20-t nice-copy">
                        <div class="col-sm-4">
                            <div class="text-center push-30">
                                <span class="item item-2x item-circle border">
                                    <i class="si si-rocket"></i>
                                </span>
                            </div>
                            <h4 class="h3 font-w300 text-center push-10">Powerful &amp; Flexible</h4>
                            <p class="h5 text-center text-muted">With our free plan you can start selling without paying anything and join our very powerful community. Save your time and focus on creating great items and build your fanbase. </p>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center push-30">
                                <span class="item item-2x item-circle border">
                                    <i class="si si-wallet"></i>
                                </span>
                            </div>
                            <h4 class="h3 font-w300 text-center push-10">Super Fast Direct Payment</h4>
                            <p class="h5 text-center text-muted">You don't need to wait a month or request payouts. Whenever a sale is processed and completed you'll instantly get money paid to your Paypal or Stripe account. </p>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center push-30">
                                <span class="item item-2x item-circle border">
                                    <i class="fa fa-percent"></i>
                                </span>
                            </div>
                            <h4 class="h3 font-w300 text-center push-10">Ultra-low Commissions</h4>
                            <p class="h5 text-center text-muted">While you keep paying 50% commissions and more elsewhere we offer you ultra low commissions with our growing plans so you can keep more of your earnings and pay what you need.</p>
                        </div>
                        <div class="row nice-copy">
                            <div class="col-sm-4">
                                <div class="text-center push">
                                    <span class="item item-2x item-circle border">
                                        <i class="fa fa-paint-brush"></i>
                                    </span>
                                </div>
                                <h4 class="h3 font-w300 text-center push-10">Beautiful Design</h4>
                                <p class="h5 text-center text-muted">Your profile page and the product page are designed carefully to present your items in the best way possible.</p>
                            </div>

                            <div class="col-sm-4">
                                <div class="text-center push">
                                    <span class="item item-2x item-circle border">
                                        <i class="fa fa-mobile-phone fa-2x push-10-t"></i>
                                    </span>
                                </div>
                                <h4 class="h3 font-w300 text-center push-10">Responsive Design</h4>
                                <p class="h5 text-center text-muted">Fully responsive and optimized pages help you to sell your items wherever your customers are.</p>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-center push">
                                    <span class="item item-2x item-circle border">
                                        <i class="si si-music-tone-alt push-10-t"></i>
                                    </span>
                                </div>
                                <h4 class="h3 font-w300 text-center push-10">Grow Your Fanbase</h4>
                                <p class="h5 text-center text-muted">Grow your fanbase while selling your items and become a wanted leader with your music.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div>
                <section class="content content-full content-boxed">
                    <div class="text-center">
                        <h1 class="font-s48 font-w300 text-darker animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">Features</h1>
                        <h4 class="h4 font-w400 text-muted animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">Sell your music packs, presets or lease music to youtubers while growing your fanbase</h4>
                    </div>
                </section>
                <span class="text-center push-100-l"><img src="{{asset('images/photos/mockup2.jpg')}}" alt="" border="0" width="1000" height="769"></span>
                <div class="row items-push-3x push-20-t nice-copy">
                    <div class="col-sm-4">
                        <div class="text-center push-30">
                            <span class="item item-2x item-circle border">
                                <i class="si si-rocket"></i>
                            </span>
                        </div>
                        <h4 class="h3 font-w300 text-center push-10">Analytics</h4>
                        <p class="h5 text-center text-muted">Powerful insights with sale statistics and analytics of your items and profile.</p>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-center push-30">
                            <span class="item item-2x item-circle border">
                                <i class="si si-wallet"></i>
                            </span>
                        </div>
                        <h4 class="h3 font-w300 text-center push-10">Super Fast Direct Payment</h4>
                        <p class="h5 text-center text-muted">You don't need to wait a month or request payouts. Whenever a sale is processed and completed you'll instantly get money paid to your Paypal or Stripe account. </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-center push-30">
                            <span class="item item-2x item-circle border">
                                <i class="fa fa-percent"></i>
                            </span>
                        </div>
                        <h4 class="h3 font-w300 text-center push-10">Ultra-low Commissions</h4>
                        <p class="h5 text-center text-muted">While you keep paying 50% commissions and more elsewhere we offer you ultra low commissions with our growing plans so you can keep more of your earnings and pay what you need.</p>
                    </div>
                    <div class="row nice-copy">
                        <div class="col-sm-4">
                            <div class="text-center push">
                                <span class="item item-2x item-circle border">
                                    <i class="si si-tag"></i>
                                </span>
                            </div>
                            <h4 class="h3 font-w300 text-center push-10">Mighty Sale Tools</h4>
                            <p class="h5 text-center text-muted">Offer discounts to attract more customers or share free items to your followers and grow your audience faster than ever.</p>
                        </div>

                        <div class="col-sm-4">
                            <div class="text-center push">
                                <span class="item item-2x item-circle border">
                                    <i class="fa fa-mobile-phone fa-2x push-10-t"></i>
                                </span>
                            </div>
                            <h4 class="h3 font-w300 text-center push-10">Responsive Design</h4>
                            <p class="h5 text-center text-muted">Fully responsive and optimized pages help you to sell your items wherever your customers are.</p>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center push">
                                <span class="item item-2x item-circle border">
                                    <i class="si si-music-tone-alt push-10-t"></i>
                                </span>
                            </div>
                            <h4 class="h3 font-w300 text-center push-10">Grow Your Fanbase</h4>
                            <p class="h5 text-center text-muted">Grow your fanbase while selling your items and become a featured community leader with your music.</p>
                        </div>
                    </div>
                </div>
                <div class="row items-push-2x push-30-t nice-copy">
                </div>
            </div>
        </section>

                    <section class="bg-white">
                        <!-- Section Content -->
                        <div class="row items-push-2x push-10-t push-30-l nice-copy align-middle">

              <div class="col-sm-7 animated flipInY text-center push-100 push-50-t"> <img src="{{asset('images/various/rocket-plans.jpg')}}" alt="" border="0" style="height:60%;width:60%;"></div>
              <div class="col-sm-4 push-100 animated slideInUp">
              <h1 class="font-w300 text-left push-5">Monetize Your Passion!</h1>
              <h3 class="font-w400 text-left push-30">Everything at one place</h3>
              <p class="h4 text-muted push-50">Selling your items in many places can be hard. Take action today and start selling your items at one place, keep almost all of your income, build your customer base while growing
              as an expert on platform designed for creatives.</p>
              <span class="h5">Start for free - no credit card required <span style="float:right;"><i class="fa fa-check font-w300 text-success-modern" aria-hidden="true"></i></span></span>
              <hr>
              <span class="h5">Grow your sales step by step<span style="float:right;"><i class="fa fa-check font-w300 text-success-modern" aria-hidden="true"></i></span></span>
              <hr>
              <span class="h5">Add and manage unlimited items<span style="float:right;"><i class="fa fa-check font-w300 text-success-modern" aria-hidden="true"></i></span></span>
              <hr>
              <span class="h5">Track Sales and use automated marketing tools<span style="float:right;"><i class="fa fa-check font-w300 text-success-modern" aria-hidden="true"></i></span></span>
              <hr>
              <span class="h5">Become an expert in a creative community<span style="float:right;"><i class="fa fa-check font-w300 text-success-modern" aria-hidden="true"></i></span></span>

                   </div>
              <div class="col-sm-1"></div>

                        </div>
                        <!-- END Section Content -->
                    </section>

        </div>


    <div class="bg-image" style="background-image:url('{{asset('images/headers/newsletter-bg.jpg')}}');">
        <section class="content content-boxed overflow-hidden">
            <div class="row push-20-t push-20">
                <h1 class="font-w300 text-white text-center animated fadeInUp push-20-l push-50">Choose Your Plan &amp; Start Selling</h1>
                <plans secret="{{ config('services.stripe.key') }}"></plans>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
    <div class="support-bg">
        <section class="content content-full content-boxed">
            <!-- Section Content -->
            <div class="push-50-t push-50 nice-copy">
                <!-- Feature List -->
                <div class="row items-push">
                    <div class="col-sm-6">
                        <h3 class="h3 font-w300 push-10"><i class="fa fa-check text-success-modern push-5-r"></i> Great Support</h3>
                        <p>We are committed to help you were we can so you can focus on creating great items. With our support we also try to help you to generate more sales and selling your item in the best way possible. We regularly update our support knowledgebase and blog with knowledge for sellers.</p>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="h3 font-w300 push-10"><i class="fa fa-check text-success-modern push-5-r"></i> Rich Seller Features</h3>
                        <p>You have full control over your sales in your dashboard. You can easily upload new items, manage items, create your fanbase with followers and build your fan base all in one place. Create a huge follower base that can like and follow your items.</p>
                    </div>
                </div>
                <div class="row items-push">
                    <div class="col-sm-6">
                        <h3 class="h3 font-w300 push-10"><i class="fa fa-check text-success-modern push-5-r"></i>Direct Payment Split</h3>
                        <p>Whenever a sale has been made your portion of the sale directly goes to your Paypal or Stripe account. No need to request payouts or withdraw money.</p>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="h3 font-w300 push-10"><i class="fa fa-check text-success-modern push-5-r"></i> Public Profile</h3>
                        <p>Within your dashboard you can see how many sales you had and how much you earned. With your public profile you can get ratings and build your fan base and follow others. </p>
                    </div>
                </div>
                <div class="row items-push">
                    <div class="col-sm-6">
                        <h3 class="h3 font-w300 push-10"><i class="fa fa-check text-success-modern push-5-r"></i> Cancel anytime</h3>
                        <p>You can start with a free plan or any of the advanced plans. While growing your business you can cancel your subscription plan anytime.</p>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="h3 font-w300 push-10"><i class="fa fa-check text-success-modern push-5-r"></i> Affiliate Sales</h3>
                        <p>With all plans you can generate affiliate links for products from others and earn a commission on every sale. You can even start earning from affiliate sales from a free plan.</p>
                    </div>
                </div>
                <!-- END Feature List -->
            </div>
            <!-- END Section Content -->
        </section>



    </div>
    <div class="bg-modern-dark2">
        <div class="bg-modern-dark2 row content-boxed">
            <div class="col-sm-6 col-lg-4 push-20-t push-20">
                <div class="block font-w200">
                    <div class="block-content bg-modern-dark2 text-white">
                        <span class="h2 font-w300">Newsletter</span>  <br>
                        <span class="h5 font-w500">Get the latest news and stay updated.</span>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-8">
                <div class="block">
                    <div class="block-content bg-modern-dark2">
                        <div class="block-content block-content-narrow block-content-full">
                            <form class="form-inline" action="http://newsletter.roqstaraudio.com/lists/58d5826f2cb55/embedded-form-subscribe-captcha" method="post">
                                <div class="form-group">
                                    <label class="sr-only" for="FIRST_NAME">Name</label>
                                    <input class="form-control input-lg" name="FIRST_NAME" placeholder="Enter Name.." type="text">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="EMAIL">Email</label>
                                    <input class="form-control input-lg" name="EMAIL" placeholder="Enter Email.." type="email">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success-modern btn-modern-light font-open-sans font-w400 btn-lg" type="submit">Subscribe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection