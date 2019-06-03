<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
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
                            <h3 class="font-w600">Book Blog Post</h3>
                        </div>
                        <div class="block-content">
                            <p class="alert alert-info" v-html="info"></p>
                            <div class="row" style="margin-top: 35px; margin-bottom: 35px">
                                <credit-card ref="card" :form="form" :errors="errors" v-on:changetoken="changeToken" :secret="secret" :card_id="'card-element-pay'"></credit-card>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center">
                            <button class="btn btn-lg btn-success-modern push-right font-w400" type="button" v-on:click.prevent="book($event)" :disabled="!form.token">Book</button>
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
                    email: null,
                    firstname: null,
                    lastname: null,
                    card_name: null,
                    card_brand: null,
                    card_last_four: null,
                    token: null,
                },
                errors: {},
                button: null,
                info: null
            }
        },
        props: {
            secret: {
                required: true
            },
            story_price: {
                required: true
            }
        },
        mounted: function () {
            this.currentUser = currentUser;
            this.info = 'You will be able to create new Blog Post for $' + this.story_price;
            if (this.currentUser) {
                this.form.card_name = currentUser.get('card_name', 'Test');
                this.form.card_brand = currentUser.get('card_brand');
                this.form.card_last_four = currentUser.get('card_last_four');
            }
        },
        methods: {
            book: function(event) {
                this.errors = {};
                var that = this;
                stories().book(this.form, function () {
                    that.$emit('book');
                }, function (error) {
                    if(error.response.data.message) {
                        swal('Book Blog Post', error.response.data.message, 'error');
                    }
                });
            },
            changeToken: function (token) {
                this.form.token = token;
            },
            resetCard: function () {
                this.$refs.card.clear();
                this.form.token = null;
            }
        }
    }
</script>
