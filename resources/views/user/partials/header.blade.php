    <!-- User Header -->
    <div class="block">
        <!-- Basic Info -->
        <user-header :id="id" :current="current_id" :form="form"></user-header>
        <!-- END Basic Info -->

         <!-- Stats -->
        <div class="block-content content content-boxed text-center">
            <div class="row items-push text-uppercase">
                <div class="col-xs-6 col-sm-2">
                    <div class="font-w700 text-gray-darker animated fadeIn">Followers</div>
                    <a class="h2 font-w300 text-gray animated flipInX" v-text="form.count_followers" :href="'/user/' + form.username + '/followers'"></a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <div class="font-w700 text-gray-darker animated fadeIn">Following</div>
                    <a class="h2 font-w300 text-gray animated flipInX" v-text="form.count_following" :href="'/user/' + form.username + '/following'"></a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <div class="font-w700 text-gray-darker animated fadeIn">Items</div>
                    <a class="h2 font-w300 text-gray animated flipInX" v-text="form.count_items" :href="'/user/' + form.username + '/items'"></a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <div class="font-w700 text-gray-darker animated fadeIn">Collections</div>
                    <a v-bind:href="'/user/' + form.username + '/collections'" v-text="form.count_collections" class="h2 font-w300 text-gray animated flipInX"></a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <div class="font-w700 text-gray-darker animated fadeIn">Sales</div>
                    <span class="h2 font-w300 text-gray animated flipInX" v-text="form.count_sales" href="javascript:void(0)"></span>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <div class="font-w700 text-gray-darker animated fadeIn" v-text="form.count_rating + ' Ratings'"></div>
                    <a v-bind:href="'/user/' + form.username + '/ratings'">
                    <div class="push-10-t animated flipInX">
                        <stars :rating="form.rating ? form.rating : 0"></stars>
                    </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- END Stats -->
    </div>
    <!-- END User Header -->
