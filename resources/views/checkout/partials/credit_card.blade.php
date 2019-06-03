<div class="block" id="credit-card-block">
    <div v-if="form.payment_type == 'stripe'" class="block-header">
        <h5 class="font-w300" v-text="(currentUser ? '3' : '4') + '. Credit Card'"></h5>
    </div>
    <div class="block-content">
        <!-- Card Container -->
        <div class="js-card-container hidden-xs push-50"></div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div v-if="form.payment_type == 'stripe'">
                    <div v-if="!currentUser || !currentUser.get('card_name') || form.edit_mode">
                        <div v-bind:class="'form-group'+(errors.card_name ? ' has-error' : '')">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input v-model="form.card_name" class="form-control" id="checkout-cc-name" name="checkout-cc-name" type="text" placeholder="JOHN DOE">
                                    <label for="checkout-cc-name">Full Name</label>
                                </div>
                                <span class="help-block" v-if="errors.card_name">
                                    <div v-for="error in errors.card_name"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                        <credit-card :form="form" :errors="errors" v-on:changetoken="changeToken" secret="{{ config('services.stripe.key') }}" :card_id="'card-element'"></credit-card>
                    </div>
                    <div class="form-group" v-else>
                        <div class="col-xs-12 text-center">
                            <span class="h5 font-w600">
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span v-text="' **** ' + form.card_last_four + ' : ' + form.card_name + ' '"></span>
                            </span>
                            <span class="btn btn-primary btn-md" v-on:click="form.edit_mode = true"><i class="fa fa-edit"></i> Edit</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 text-center">
                        <button v-on:click="completeOrder($event)" class="btn btn-success-modern btn-lg font-s50" type="submit" data-style="expand-right"><i class="fa fa-check push-5-r"></i> Complete Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>