<template>
    <div v-if="!collection.isEmpty()" class="row push-20-t push-20">
        <h3 class="font-w300 animated fadeInUp push-20-l"><i class="si si-rocket"></i> Promotional Subscriptions</h3>
        <h6 class="font-w400 animated fadeInUp push-20-l push-20 text-muted">Promote your items with a subscription and earn more</h6>

        <div v-for="plan in collection.getData()" class="col-sm-6 col-lg-3 animated fadeInUp" data-toggle="appear" data-offset="50" data-class="animated fadeInUp">
            <a class="block block-bordered block-link-hover3 text-center" href="javascript:void(0)">
                <div class="block-header bg-amethyst-dark">
                    <h3 class="font-w300 text-white" v-text="plan.get('name')"></h3>
                </div>
                <div class="block-content block-content-full bg-gray-lighter">
                    <div class="h1 font-w300 push-10">{{ plan.get('price') | currency }}</div>
                    <div class="h5 font-w300 text-muted">per item</div>
                </div>
                <div class="block-content">
                    <table class="table table-borderless table-condensed">
                        <tbody>
                        <tr>
                            <td><strong v-text="plan.get('item_number')"></strong>{{ plan.get('item_number') | pluralize('item') }}</td>
                        </tr>
                        <tr>
                            <td><strong v-text="plan.get('duration')"></strong> {{ plan.get('duration_type') | pluralize(plan.get('duration_type')) }} promotion</td>
                        </tr>
                        <tr>
                            <td>shown in featured items</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="block-content block-content-mini block-content-full bg-gray-lighter text-white">
                    <span class="btn btn-success-modern btn-md" v-on:click.prevent="modal(plan)">Buy</span>
                </div>
            </a>
        </div>
        <promo-buy id="modal-promo" ref="buy" v-on:buy="buyed" :secret="secret"></promo-buy>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                collection: new PromoPlans(),
            };
        },
        props: {
            secret: {
                required: true
            }
        },
        computed: {
            currentUser: function() {
                return currentUser;
            }
        },
        mounted: function () {
            this.getList();
            var _this = this;
            $(document).on('hidden.bs.modal', '#modal-promo', function (event) {
                _this.$refs.buy.resetCard();
            });
        },
        methods: {
            getList: function() {
                var vm = this;
                promoPlans().all(function(collection) {
                    vm.collection = collection;
                }, function(){
                }, Object.assign({}, queryString.parse(location.search)));
            },
            modal: function(plan) {
                this.$refs.buy.setPlan(plan);
                $('#modal-promo').modal('toggle');
            },
            buyed: function () {
                $('#modal-promo').modal('toggle');
                toastr.success("Promotional subscription completed successfully!", 'Promotional subscription');
            }
        }
    }
</script>
