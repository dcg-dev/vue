<div class="block">
    <div class="block-header">
        <h5 class="font-w300">Choose Your Payment Option</h5>
    </div>
    <div class="block-content">
        <!-- Card Container -->
        <div class="js-card-container hidden-xs"></div>
        <div class="row">
            <div class="col-sm-6 col-lg-6">
                <a class="block block-link-hover2"  v-on:click="choosePayment('paypal')">
                    <div class="block-content block-content-full text-center bg-gray-light">
                        <div>
                            <i class="fa fa-cc-paypal text-primary font-s128"></i>
                        </div>
                        <div class="text-muted">Paypal</div>
                    </div>
                </a>
           </div>
           <div class="col-sm-6 col-lg-6">
                <a class="block block-link-hover2" v-on:click="choosePayment('stripe')">
                    <div class="block-content block-content-full text-center">
                        <div>
                            <i class="fa fa-cc-stripe text-amethyst font-s128"></i>
                        </div>
                        <div class="text-muted">Pay with Stripe</div>
                    </div>
                </a>
           </div>
        </div>
    </div>
</div>