<div class="bg-gray-lighter">
    <section class="content content-boxed">
        <div v-if="!arrivals.isEmpty()">
            <h3 class="font-w300 text-light push-30-t">New Arrivals</h3>
            <h5 class="font-w400 text-muted push-20">The latest items from our community</h5>
            <items :collection="arrivals"></items>
            <div class="row">
                <div class="col-xs-12 text-right push text-gray">
                    <a class="btn btn-success-modern font-w300"
                       href="{{ urldecode(route('items', ['order' => ['latest']])) }}">View More New Arrivals</a>
                </div>
            </div>
        </div>

        <div v-if="!populars.isEmpty()">
            <h3 class="font-w300 text-light push-30-t">Populars</h3>
            <h5 class="font-w400 text-muted push-20">The popular items from our community</h5>
            <items :collection="populars"></items>
            <div class="row">
                <div class="col-xs-12 text-right push text-gray">
                    <a class="btn btn-success-modern font-w300"
                       href="{{ urldecode(route('items', ['order' => ['popular']])) }}">View More Populars</a>
                </div>
            </div>
        </div>

        <div v-if="!featured.isEmpty()">
            <h3 class="font-w300 text-light push-30-t">Featured Items</h3>
            <h5 class="font-w400 text-muted push-20">Items that have been featured</h5>
            <items :collection="featured" item-class="col-sm-6 col-lg-2" item-title-class="h5 push-10"></items>
            <div class="row">
                <div class="col-xs-12 text-right push text-gray">
                    <a class="btn btn-success-modern font-w300" href="{{route('featured')}}">More Featured Items</a>
                </div>
            </div>
        </div>

        <div v-if="!sellers.isEmpty()">
            <h3 class="font-w300 text-light push-30-t">Top Sellers</h3>
            <h5 class="font-w400 text-muted push-20">Producers with top selling items</h5>
            <sellers :collection="sellers"></sellers>
            <div class="row">
                <div class="col-xs-12 text-right push text-gray">
                    <a class="btn btn-success-modern font-w300" href="/sellers/top">View More Top Sellers</a>
                </div>
            </div>
        </div>

    </section>
</div>