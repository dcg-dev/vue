<div class="bg-image" style="background-image: url('{{asset('images/headers/newsletter-bg.jpg')}}');">
    <div class="bg-primary-light-op">
        <section class="content content-full content-boxed">
            <!-- Section Content -->
            <div class="push-65-t push-50 text-center">
                <h1 class="h1 text-white-op font-w300" data-toggle="appear"
                    data-class="animated fadeInDown">{{number_format(Setting::get('items', 0),0,".","'")}} Digital Audio
                    Items</h1>
                <h2 class="h5 text-white-op push-30" data-toggle="appear" data-class="animated fadeInDown">Find
                    Inspiration And Music For Your Creative Projects</h2>
                <dashboard-search></dashboard-search>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
</div>