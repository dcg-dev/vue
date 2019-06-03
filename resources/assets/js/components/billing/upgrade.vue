<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog modal-dialog-popout vertical-align-center">
                <div class="modal-content">
                    <div class="block block-themed block-transparent block-rounded remove-margin-b">
                        <div class="block-header bg-white">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i
                                            class="si si-close fa-2x text-gray"></i></button>
                                </li>
                            </ul>
                            <h3 class="font-w600" v-if="plan">Subscription  {{plan.get('button', '')}}</h3>
                        </div>
                        <div class="block-content">
                            <p class="alert alert-info" v-html="info"></p>

                            <div class="row" style="margin-top: 35px; margin-bottom: 35px">
                                <credit-card ref="card" card_id="upgrade" :form="form" :errors="errors"
                                             v-on:changetoken="changeToken" :secret="secret"
                                             :card_id="'card-element-subscriptions'"></credit-card>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center">
                            <button class="btn btn-lg btn-success-modern push-right font-w400" type="button"
                                    v-on:click.prevent="upgrade($event)" :disabled="disabledButton">Upgrade
                            </button>
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
            return {
                disabledButton: false,
                currentUser: {},
                form: {
                    email: null,
                    firstname: null,
                    lastname: null,
                    card_name: null,
                    card_brand: null,
                    card_last_four: null,
                    token: null,
                },
                errors: {},
                info: '',
                plan: false,
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
            upgrade: function (event) {
                this.errors = {};
                this.disabledButton = true;
                this.$refs.card.card.blur();
                if (this.form.token) {
                    this.errors = {};
                    var that = this;
                    this.plan.subscribe(this.plan.get('id'), this.form, function () {
                        that.$emit('upgrade');
                        that.disabledButton = false;
                    }, function (error) {
                        that.disabledButton = false;
                    });
                } else {
                    this.disabledButton = false
                    this.errors = {
                        token: [
                            'Please fill in the credit card details.'
                        ],
                    };
                }
            },
            changeToken: function (token) {
//                console.log(token);
                this.form.token = token;
            },
            setPlan: function (plan) {
                this.plan = plan;
                this.info = 'You have chosen a <b>' + this.plan.get('name') + '</b> plan for <b>$' + this.plan.getPrice() + '</b> / per month.';
            },
            resetCard: function () {
                this.$refs.card.clear();
                this.form.token = null;
            }

        }
    }
</script>
