<template>   
    <div class="bg-white">
        <section class="content content-boxed overflow-hidden">
            <!-- Section Content -->
            <div class="content-grid">
                <div class="row">
                    <div v-on:click="setFilter('account', $event)" class="col-xs-6 col-sm-3 animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
                        <a class="block block-bordered block-rounded block-link-hover3" href="javascript:void(0)">
                            <div class="block-content block-content-full border-b text-center">
                                <div class="item">
                                    <i class="si si-user text-amethyst"></i>
                                </div>
                            </div>
                            <div class="block-content block-content-full block-content-mini">
                                <span class="font-w600 text-uppercase"><span class="badge badge-default pull-right" v-text="account"></span> Account</span>
                            </div>
                        </a>
                    </div>
                    <div v-on:click="setFilter('features', $event)" class="col-xs-6 col-sm-3 animated fadeInDown" data-toggle="appear" data-timeout="200" data-class="animated fadeInDown">
                        <a class="block block-bordered block-rounded block-link-hover3" href="javascript:void(0)">
                            <div class="block-content block-content-full border-b text-center">
                                <div class="item">
                                    <i class="si si-settings text-city"></i>
                                </div>
                            </div>
                            <div class="block-content block-content-full block-content-mini">
                                <span class="font-w600 text-uppercase"><span class="badge badge-default pull-right" v-text="features"></span> Features</span>
                            </div>
                        </a>
                    </div>
                    <div v-on:click="setFilter('services', $event)" class="col-xs-6 col-sm-3 animated fadeInDown" data-toggle="appear" data-timeout="400" data-class="animated fadeInDown">
                        <a class="block block-bordered block-rounded block-link-hover3" href="javascript:void(0)">
                            <div class="block-content block-content-full border-b text-center">
                                <div class="item">
                                    <i class="si si-target text-flat"></i>
                                </div>
                            </div>
                            <div class="block-content block-content-full block-content-mini">
                                <span class="font-w600 text-uppercase"><span class="badge badge-default pull-right" v-text="services"></span> Services</span>
                            </div>
                        </a>
                    </div>
                    <div v-on:click="setFilter('payment', $event)" class="col-xs-6 col-sm-3 animated fadeInDown" data-toggle="appear" data-timeout="600" data-class="animated fadeInDown">
                        <a class="block block-bordered block-rounded block-link-hover3" href="javascript:void(0)">
                            <div class="block-content block-content-full border-b text-center">
                                <div class="item">
                                    <i class="si si-wallet text-smooth"></i>
                                </div>
                            </div>
                            <div class="block-content block-content-full block-content-mini">
                                <span class="font-w600 text-uppercase"><span class="badge badge-default pull-right" v-text="payment"></span> Payment</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        props: {
            account: {
                required: true
            },
            features: {
                required: true
            },
            services: {
                required: true
            },
            payment: {
                required: true
            }
        },
        mounted: function () {
        },
        methods: {
            setFilter: function (type, event) {
                this.$parent.setFilter(type, event);
            }
        }
    }
</script>