<template>
    <div v-bind:class="'form-group'+(cardError || errors.token ? ' has-error' : '')">
        <div class="col-xs-12">
            <div class="form-material">
                <div v-bind:id="card_id" class="form-control"></div>
                <label for="checkout-cc-number">Card</label>
            </div>
            <span class="help-block" v-if="cardError || errors.token">
                <div><strong v-text="cardError ? cardError : errors.token[0]"></strong></div>
            </span>
        </div>
    </div>            
</template>

<script>
    export default {
        props: {
            form: {
                type: Object,
                required: true
            },
            errors: {
                required: true
            },
            secret: {
                type: String,
                required: true
            },
            card_id: {
                type: String,
                required: true
            }
        },
        data: function() {
            return {
                cardError: null,
                card: null
            };
        },
        computed: {
            stripe: function() {
                return Stripe(this.secret);
            },
        },
        mounted: function () {
            var that = this;
            var elements = that.stripe.elements();
            that.card = elements.create('card', {
                hidePostalCode: true,
            });
            that.card.mount("#" + that.card_id);
            that.card.on('change', function(event) {
                that.setOutcome(event);
            });
        },
        methods: {
            setOutcome: function (result) {
                this.cardError = null;
                if (result.token) {
                    this.$emit('changetoken', result.token.id);
                }
                else if (result.error) {
                    this.cardError = result.error.message;
                } else if (result.complete) {
                    if (!this.form.card_name) {
                        this.cardError = 'First fill Full Name field, then try to fill Card field again.';
                        return;
                    }
                    var extraDetails = {
                        name: this.form.card_name ? this.form.card_name : '',
                    };
                    this.stripe.createToken(this.card, extraDetails).then(this.setOutcome);
                } 
            },
            completeOrder: function (event) {
                
            },
            clear: function () {
                this.card.clear();
            }
        }
    }
</script>
