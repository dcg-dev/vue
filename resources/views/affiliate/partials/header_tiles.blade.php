<!-- Header Tiles -->
<div class="row">
    <div class="col-sm-6 col-md-3">
        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
            <div class="block-content block-content-full">
                <div class="h1 font-w300 text-success" v-if="'undefined' !== typeof info.open_amount" v-text="'$ ' + parseFloat(info.open_amount).toFixed(2)"></div>
                <div class="h1 font-w300 text-success" v-else>NaN</div>
            </div>
            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w400">Open Amount</div>
        </a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
            <div class="block-content block-content-full">
                <div class="h1 font-w300" v-if="'undefined' !== typeof info.sales_today" v-text="info.sales_today"></div>
                <div class="h1 font-w300" v-else>NaN</div>
            </div>
            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w400">Today</div>
        </a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
            <div class="block-content block-content-full">
                <div class="h1 font-w300" v-if="'undefined' !== typeof info.total_referrals" v-text="info.total_referrals"></div>
                <div class="h1 font-w300" v-else>NaN</div>
            </div>
            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w400">Total Referrals</div>
        </a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
            <div class="block-content block-content-full">
                <div class="h1 font-w300" v-if="'undefined' !== typeof info.total_earned" v-text="'$ ' + parseFloat(info.total_earned).toFixed(2)"></div>
                <div class="h1 font-w300" v-else>NaN</div>
            </div>
            <div class="block-content block-content-full block-content-mini bg-gray-lighter text- font-w400">Total Earned</div>
        </a>
    </div>
</div>
<!-- END Header Tiles -->