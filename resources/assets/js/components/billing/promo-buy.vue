<template>
    <div class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog modal-dialog-popout vertical-align-center">
                <div class="modal-content">
                    <div class="block block-themed block-transparent block-rounded remove-margin-b">
                        <div class="block-header bg-white">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close fa-2x text-gray"></i></button>
                                </li>
                            </ul>
                            <h3 class="font-w600">Promotional Subscription</h3>
                        </div>
                        <div class="block-content">
                            <p class="alert alert-info" v-html="info"></p>

                            <div class="form-group">
                                <label>Choose item</label>
                                <items-select v-model="form.item" class="form-control" :query="{status: 2}" style="width: 100%"></items-select>
                            </div>
                            <div class="row" style="margin-top: 35px; margin-bottom: 35px">
                                <credit-card ref="card" card_id="promo" :form="form" :errors="errors" v-on:changetoken="changeToken" :secret="secret"></credit-card>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center">
                            <button class="btn btn-lg btn-success-modern push-right font-w400" type="button" v-on:click.prevent="upgrade($event)" :disabled="!form.token || !form.item">Promote</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                currentUser: {},
                form: {
                    token: null,
                    item: null
                },
                errors: {},
                info: '',
                plan: {},
                button: null
            }
        },
        props: {
            secret: {
                required: true
            }
        },
        mounted: function () {
            this.currentUser = currentUser;
            if (this.currentUser) {
                this.form.card_name = currentUser.get('card_name', 'Test');
                this.form.card_brand = currentUser.get('card_brand');
                this.form.card_last_four = currentUser.get('card_last_four');
            }
        },
        methods: {
            upgrade: function(event) {
                this.errors = {};
                var that = this;
                this.plan.buy(this.plan.get('id'), this.form, function () {
                    that.$emit('buy');
                }, function (error) {
                });
            },
            changeToken: function (token) {
                this.form.token = token;
            },
            setPlan: function (plan) {
                this.plan = plan;
                this.info = 'You have chosen a <b>' + this.plan.get('name') +'</b> plan for <b>$' + this.plan.getPrice() + '</b> / per item.';
            },
            resetCard: function () {
                this.$refs.card.clear();
                this.form.token = null;
                this.form.item = null;
                $('.select2-selection__rendered').text('');
            }

        }
    }
</script>
