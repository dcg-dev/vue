@extends('layouts.main')
@section('title', 'Pricing')
@section('content')
<div id="pricing-page">
    <div class="bg-image" style="background-image:url('{{asset('images/headers/newsletter-bg.jpg')}}');">
        <section class="content content-boxed overflow-hidden">
            <!-- Section Content -->
            <div class="row push-30-t push-50">
                <h1 class="font-s48 font-w300 text-white text-center animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">Pricing</h1>
                <h4 class="h4 font-w300 text-white text-center animated fadeInDown push-30" data-toggle="appear" data-class="animated fadeInDown">Choose the right plan and grow.</h4>
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
                        <h3 class="h3 font-w300 push-10"> How do I get paid? </h3>
                        <p>Whenever a sale has been made your portion of the sale directly goes to your Paypal or Stripe account. No need to request payouts or withdraw money.</p>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="h3 font-w300 push-10">Do I need to have a website or shop?</h3>
                        <p>No, you can sell without having your own website or taking the time-consuming process of programming your own website. You can subscribe and start right away selling your items.</p>
                    </div>
                </div>
                <div class="row items-push">
                    <div class="col-sm-6">
                        <h3 class="h3 font-w300 push-10">Do I need to have Paypal?</h3>
                        <p>Ìf you don't like Paypal you can receive money with your Stripe account.</p>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="h3 font-w300 push-10">What fees do I need to pay?</h3>
                        <p>Besides our transaction fee you pay the transaction fee of Paypal and Stripe.</p>
                    </div>
                </div>
                <div class="row items-push">
                    <div class="col-sm-6">
                        <h3 class="h3 font-w300 push-10">Why do you charge a transaction fee?</h3>
                        <p>Hosting your files and paying for the traffic whenever someone streams your demo or looks at your product costs money. We also offer the fastest download speeds for your files worldwide from various servers. Our infrastructure has been built especially to serve high traffic needs which is also not that simple. This all costs money. Then we also provide support and many valuable tools to help you earn money from your items.</p>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="h3 font-w300 push-10">Why should I subscribe to a monthly plan?</h3>
                        <p>Not only you can create your follower base all in one place but you can also save huge profits. While you pay large commissions at other distribution platforms you can keep a maximum of your profit.</p>
                    </div>
                </div>
                <!-- END Feature List -->
            </div>
            <!-- END Section Content -->
        </section>
    </div>
    <!-- Newsletter -->
    <div class="bg-flat-dark">
        <div class="bg-flat-dark row content-boxed">
            <div class="col-sm-6 col-lg-4 push-20-t push-20">
                <div class="block font-w200">
                    <div class="block-content bg-flat-dark text-white">
                        <span class="h2 font-w300">Newsletter</span>  <br>
                        <span class="h5 font-w500">Get the latest news and stay updated.</span>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-8">
                <div class="block">
                    <div class="block-content bg-flat-dark">
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
    <!-- END Newsletter -->
</div>
@endsection
