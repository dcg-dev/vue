<template>
    <div>
        <div v-if="!collection.isEmpty()" class="col-sm-6 col-lg-4 animated fadeInUp" data-toggle="appear"
             data-offset="50" data-class="animated fadeInUp" v-for="(plan, index) in collection.getData()">
            <div class="block block-bordered block-link-hover3 text-center">
                <div class="block-header">
                    <h3 v-bind:class="'font-w300' + (collection.center() == index ? ' text-success' : '')"
                        v-text="plan.get('name')"></h3>
                </div>
                <div class="block-content block-content-full bg-gray-lighter">
                    <div v-bind:class="'h1 font-w300 push-10' + (collection.center() == index ? ' text-success' : '')">
                        ${{plan.getPrice()}}
                    </div>
                    <div class="h5 font-w300 text-muted">per month</div>
                </div>
                <div class="block-content">
                    <table class="table table-borderless table-condensed text-left">
                        <tbody>
                        <tr>
                            <td><i class="fa fa-check text-success"></i> Beautiful Profile Page</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-check text-success"></i> Instant Payout</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-check text-success"></i> Powerful Analytics</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-check text-success"></i> {{plan.get('products', 0)}} Products</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-check text-success"></i> {{plan.getCommission()}}% Commission</td>
                        </tr>
                        <tr>
                            <td v-if="plan.bool('paypal')"><i class="fa fa-check text-success"></i> Paypal Gateway</td>
                            <td v-if="!plan.bool('paypal')" class="text-gray"><i class="fa fa-times text-gray"></i>
                                Paypal Gateway
                            </td>
                        </tr>
                        <tr>
                            <td v-if="plan.bool('card')"><i class="fa fa-check text-success"></i> Stripe Gateway</td>
                            <td v-if="!plan.bool('card')" class="text-gray"><i class="fa fa-times text-gray"></i>
                                Stripe Gateway
                            </td>
                        </tr>
                        <tr>
                            <td v-if="plan.bool('badge')"><i class="fa fa-check text-success"></i>
                                Badge
                                <span v-if="plan.get('badge', 'pro') == 'pro'"
                                      class="badge badge-success-modern">PRO</span>
                                <span v-if="plan.get('badge', 'pro') == 'pro_plus'" class="badge badge-success-modern">PRO+</span>
                            </td>
                            <td v-if="!plan.bool('badge')" class="text-gray">
                                <i class="fa fa-times text-gray"></i>
                                Badge <span class="badge badge-muted">PRO</span>
                            </td>
                        </tr>
                        <tr>
                            <td v-if="plan.bool('social_accounts')"><i class="fa fa-check text-success"></i>
                                Social Accounts
                            </td>
                            <td v-if="!plan.bool('social_accounts')" class="text-gray"><i
                                    class="fa fa-times text-gray"></i> Social Accounts
                            </td>
                        </tr>
                        <tr>
                            <td v-if="plan.bool('builder')"><i class="fa fa-check text-success"></i>
                                Fan Base Building Tools
                            </td>
                            <td v-if="!plan.bool('builder')" class="text-gray"><i class="fa fa-times text-gray"></i>
                                Fan Base Building Tools
                            </td>
                        </tr>
                        <tr>
                            <td v-if="plan.bool('notifications')"><i class="fa fa-check text-success"></i>
                                Email Notifications
                            </td>
                            <td v-if="!plan.bool('notifications')" class="text-gray"><i
                                    class="fa fa-times text-gray"></i> Email Notifications
                            </td>
                        </tr>
                        <tr>
                            <td v-if="plan.bool('support')"><i class="fa fa-check text-success"></i> Advanced Support
                            </td>
                            <td v-if="!plan.bool('support')" class="text-gray"><i class="fa fa-times text-gray"></i>
                                Advanced Support
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="block-content block-content-mini block-content-full bg-gray-lighter">
                    <div v-if="currentUser">
                        <button v-bind:class="'btn btn-default font-w400 active' + (collection.center() == index ? ' btn-lg' : '')"
                                type="button" v-if="currentUser.subscribed(plan.get('stripe_id'))" disabled="true">Active
                        </button>
                        <button v-bind:class="'btn font-w400' + (collection.center() == index ? ' btn-lg' : '')+(plan.get('button') == 'Downgrade' ? ' btn-danger' : ' btn-success-modern')"
                                type="button" v-if="!currentUser.subscribed(plan.get('stripe_id'))"
                                v-on:click.prevent="modal(plan, $event)" :disabled="processed">
                            {{plan.get('button')}}
                        </button>
                    </div>
                    <div v-if="!currentUser">
                        <a href="/register"
                           v-bind:class="'btn btn-success-modern btn-outline' + (collection.center() == index ? ' btn-lg' : '')">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
        <subscription-upgrade id="modal-subscribe" ref="subscribe" v-on:upgrade="upgraded"
                              :secret="secret"></subscription-upgrade>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                collection: new Plans(),
                button: null,
                active: new Plan(),
                processed: false,
            };
        },
        props: {
            secret: {
                required: true
            }
        },
        computed: {
            currentUser: function () {
                return currentUser;
            }
        },
        mounted: function () {
            this.getList();
            var _this = this;
            $('#modal-subscribe').on('hidden.bs.modal', function () {
                _this.$refs.subscribe.resetCard();
            });
            this.active = currentUser.getActivePlan();
        },
        methods: {
            getList: function () {
                var vm = this;
                plans().all(function (collection) {
                    vm.collection = collection;
                    var activePlanId = vm.active.get('stripe_plan');
                    var finded = false;
                    for (var index in vm.collection.getData()) {
                        var plan = vm.collection.index(index);
                        if (plan.get('stripe_id') == activePlanId) {
                            finded = true;
                        }
                        if (finded) {
                            plan.set('button', 'Upgrade');
                        } else {
                            plan.set('button', 'Downgrade');
                        }
                    }
                }, function () {
                }, Object.assign({}, queryString.parse(location.search)));
            },
            modal: function (plan, event) {
                var that = this;
                axios.get('/api/billing/plan/' + plan.get('id') + '/available-subscribe').then(function (response) {
                    if (response.data.status) {
                        if(plan.get('stripe_id') == FREE_PLAN) {
                            swal({
                                    title: "Are you sure you want to "+ plan.get('button').toLowerCase() +" your subscription?",
                                    text: "",
                                    type: "info",
                                    showCancelButton: true,
                                    confirmButtonText: "Yes, do it!"
                                },
                                function(){
                                    that.processed = true;
                                    plan.subscribe(plan.get('id'), {}, function () {
                                        that.upgraded();
                                    }, function (error) {
                                        that.processed = false;
                                    });
                            });
                        } else {
                            that.$refs.subscribe.setPlan(plan);
                            $('#modal-subscribe').modal('toggle');
                        }
                    } else {
                        notify.error("In order to downgrade to this plan you need to reduce your items quantity to the allowed maximum of this plan.", 'Subscription');
                    }
                }, function (error) {
                    notify.error("An error occurred, please try again later.", 'Subscription');
                })
            },
            upgraded: function () {
                $('#modal-subscribe').modal('hide');
                notify.success("Subscription completed successfully!", 'Subscription');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            },
            available: function (plan) {

            }
        }
    }
</script>
