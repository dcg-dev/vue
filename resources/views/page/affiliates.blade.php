@extends('layouts.main')
@section('title', 'Affiliates')
@section('subtitle', 'Share links and earn money')
@section('content')
    <div class="bg-img overflow-hidden" style="background-image: url({{asset('images/headers/privacy.jpg')}});">
        <div class="bg-amethyst-op">
            <div class="content">
                <div class="block block-transparent block-themed content-boxed text-center push-100-t push-100">
                    <div class="block-content push-10-l">
                        <h2 class="h1 font-w300 text-white animated fadeInDown push-5">Affiliates</h2>
                        <h4 class="h5 font-w400 text-white-op animated fadeInUp">Share links and earn money</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container">
        <!-- About Info -->
        <div class="bg-white">
            <section class="content content-boxed">
                <!-- Section Content -->
                <div class="row items-push push-20-t nice-copy">
                    <div class="col-md-8 col-sm-offset-2 text-center">
                        <p class="font-s28">Become an affiliate and share items you like with others. Whenever the item is
                            sold you will earn money into your account. All you need to be become an affiliate is an account
                            to create links. Best practices are sharing links within a blog post or social media channels.
                            Once you created a link it will stay there forever. It's super easy.</p>
                        <p class="h3 font-w300 underline push-50-t">How does it work?</p>
                        <p><i class="si si-user font-s128 text-info"></i><br class="push-10">
                            Register as a user.<br> Fill in your personal information.</p>
                        <p class="push-50-t push-50 text-gray"><i class="si si-arrow-down font-s36"></i></p>
                        <p><i class="si si-magic-wand font-s128 text-warning"></i><br class="push-10">
                            Choose an URL of an item you like. <br>Generate a link for an item you like with our affiliate
                            tool.</p>
                        <p class="push-50-t push-50 text-gray"><i class="si si-arrow-down font-s36"></i></p>
                        <p><i class="si si-share text-primary font-s128"></i><br class="push-10">
                            Share the generated link on<br>your website, blog or social media page.</p>
                        <p class="push-50-t push-50 text-gray"><i class="si si-arrow-down font-s36"></i></p>
                        <p><i class="fa fa-percent font-s128 text-success"></i><br class="push-10">
                            If someone clicks your link and buys the item<br>you will earn a commission.</p>
                    </div>
                </div>
            </section>
        </div>

        <div class="support-bg">
            <section class="content content-full ">
                <div class="push-50-t push-50 nice-copy">
                    <div class="row items-push">
                        <div class="col-md-4 col-sm-offset-2"><h3 class="h3 font-w300 push-10">
                                <i class="fa fa-check text-success-modern push-5-r"></i>
                                How much do I earn?</h3>
                            <p>You earn 10% of our portion. Here is an example. If the seller has a free account and he
                                sells an item for $40 we get a commission of 15% which equals $7.50. You will get 15% of our
                                commission which is $0.75.</p></div>
                        <div class="col-sm-4 col-sm-offset-1"><h3 class="h3 font-w300 push-10"><i
                                        class="fa fa-check text-success-modern push-5-r"></i> How is it tracked?</h3>
                            <p>It is tracked with cookies and the incoming link. If a user is reaching our site with your
                                link it will be written within the cookie on the users computer. The cookie is valid for
                                several days. If the user makes a purchase within this timeframe you will get paid. </p>
                        </div>
                    </div>
                    <div class="row items-push text-center">
                        <div class="col-sm-6 col-sm-offset-3">
                            <h3 class="h3 font-w300 push-10">
                                <i class="fa fa-check text-success-modern push-5-r"></i>How do I get paid?</h3>
                            <p>Once you reached the threshold of $30 you can easily request a payout from the affiliate
                                menu. Simply click "request payout" and type in where you want to receive the payment
                                (Paypal, Stripe or Bank). Free international bank transfer payments can only be made from a
                                payout of $100 or more. For lower amounts the affiliate pays the transfer fees.</p></div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @include('page.sselling')
@endsection
