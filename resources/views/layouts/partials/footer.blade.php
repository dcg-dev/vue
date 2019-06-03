<footer id="page-footer" class="footer-bg text-white">
    <div class="content content-boxed">
        <!-- Footer Navigation -->
        <div class="row push-10 push-30-t items-push-2x text-white">
            <div class="col-sm-2">
                <h4 class="h4 font-w300 push-20">Start Selling</h4>
                <ul class="list list-simple-mini font-s13">
                    <li>
                        <a class="font-w500" href="/start-selling">Start Selling</a>
                    </li>
                    <li>
                        <a class="font-w500" href="/pricing">Pricing</a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-2">
                <h4 class="h4 font-w300 push-20"><a href="/community" class="text-white">Community</a>
                </h4>
                <ul class="list list-simple-mini font-s13">
                    <li>
                        <a class="font-w500" href="/blog/stories">Blog</a>
                    </li>
                    <li>
                        <a class="font-w500" href="/collections/top">Collections</a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-2">
                <h4 class="h4 font-w300 push-20">Company</h4>
                <ul class="list list-simple-mini font-s13">
                    <li>
                        <a class="font-w500" href="/our-company">Our company</a>
                    </li>
                    <li>
                        <a class="font-w500" href="/affiliates">Affiliates</a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-3">
                <h4 class="h4 font-w300 push-20">Support</h4>
                <ul class="list list-simple-mini font-s13">
                    <li>
                        <a class="font-w500" href="/support/faq">Support Center</a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-2">
                <div class="push">
                    <span class="h5 font-w300">Members</span><br>
                    <span class="h2 font-w300">{{number_format(Setting::get('members', 0),0,".","'")}}</span>
                </div>

            </div>
            <div class="col-sm-1">
                <div class="push">
                    <span class="h5 font-w300">Items</span><br>
                    <span class="h2 font-w300">{{number_format(Setting::get('items', 0),0,".","'")}}</span>
                </div>
            </div>


        </div>
        <!-- END Footer Navigation -->


        <!-- Copyright Info -->
        <div class="font-s12 push-20 clearfix">
            <div class="pull-right">
                <a href="{{Setting::get('facebook.link')}}" target="_blank"><i
                            class="fa fa-facebook fa-2x push-15-r"></i></a>
                <a href="{{Setting::get('twitter.link')}}" target="_blank"><i
                            class="fa fa-twitter fa-2x  push-15-r"></i></a>
                <a href="{{Setting::get('google.link')}}" target="_blank"><i
                            class="fa fa-google-plus fa-2x  push-15-r"></i></a>
                <a href="{{Setting::get('soundcloud.link')}}" target="_blank"><i
                            class="fa fa-soundcloud fa-2x  push-15-r"></i></a>
                <a href="{{Setting::get('youtube.link')}}" target="_blank"><i
                            class="fa fa-youtube fa-2x  push-15-r"></i></a>
            </div>
            <div class="pull-left text-gray-dark">
                <span class="font-w500">ROQSTAR GmbH &copy;</span> <span class="js-year-copy">2015-{{date("y")}}</span>
            </div>
            <div class="pull-left">
                <a class="font-w300 push-20-l push-10-r" href="/privacy-policy">Privacy Policy</a></span>
            </div>
            <div class="pull-left push-10-l">
                <a class="font-w300" href="/terms-of-service">Terms of Service</a></span>
            </div>
        </div>
        <!-- END Copyright Info -->
    </div>
</footer>