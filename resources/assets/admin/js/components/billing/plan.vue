<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document" v-if="plan">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" v-text="(!plan.isNew()) ? 'Edit '+plan.get('name')+' Plan' : 'Create new Plan'"></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" v-if="!plan.isNew()">
                        <strong>Attention!</strong> If you change the price of the package, then you need to manually change it to the Stripe. This is due to the limitations of the Stripe.
                    </div>
                    <div class="row">
                        <div v-bind:class="plan.isNew() ? 'col-md-6' : 'col-md-12'">
                            <div v-bind:class="errors.name ? 'form-group has-error' : 'form-group'">
                                <label>Name</label>
                                <input type="text" class="form-control" v-model="plan.attributes.name">
                                <span class="help-block" v-if="errors.name">
                                    <div v-for="error in errors.name">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="plan.isNew()">
                            <div v-bind:class="errors.stripe_id ? 'form-group has-error' : 'form-group'">
                                <label>Stripe</label>
                                <input type="text" class="form-control" v-model="plan.attributes.stripe_id">
                                <span class="help-block" v-if="errors.stripe_id">
                                    <div v-for="error in errors.stripe_id">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="errors.price ? 'form-group has-error' : 'form-group'">
                                <label>Price</label>
                                <input type="number" class="form-control" v-model="plan.attributes.price">
                                <span class="help-block" v-if="errors.price">
                                    <div v-for="error in errors.price">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div v-bind:class="errors.products ? 'form-group has-error' : 'form-group'">
                                <label>Products</label>
                                <input type="number" class="form-control" v-model="plan.attributes.products">
                                <span class="help-block" v-if="errors.products">
                                    <div v-for="error in errors.products">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="errors.commission ? 'form-group has-error' : 'form-group'">
                                <label>Сommission</label>
                                <input type="number" class="form-control" v-model="plan.attributes.commission">
                                <span class="help-block" v-if="errors.commission">
                                    <div v-for="error in errors.commission">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div v-bind:class="errors.badge ? 'form-group has-error' : 'form-group'">
                                <label>Badge</label>
                                <select class="form-control" v-model="plan.attributes.badge">
                                    <option value="">No</option>
                                    <option value="pro">Pro</option>
                                    <option value="pro_plus">Pro+</option>
                                </select>
                                <span class="help-block" v-if="errors.badge">
                                    <div v-for="error in errors.badge">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="errors.paypal ? 'form-group has-error' : 'form-group'">
                                <label>
                                    <input type="checkbox" v-model="plan.attributes.paypal">
                                    Paypal Gateway
                                </label>
                                <span class="help-block" v-if="errors.paypal">
                                    <div v-for="error in errors.paypal">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                            <div v-bind:class="errors.card ? 'form-group has-error' : 'form-group'">
                                <label>
                                    <input type="checkbox" v-model="plan.attributes.card">
                                    Stripe Gateway (Card)
                                </label>
                                <span class="help-block" v-if="errors.card">
                                    <div v-for="error in errors.card">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                            <div v-bind:class="errors.notifications ? 'form-group has-error' : 'form-group'">
                                <label>
                                    <input type="checkbox" v-model="plan.attributes.notifications">
                                    Email notifications
                                </label>
                                <span class="help-block" v-if="errors.notifications">
                                    <div v-for="error in errors.notifications">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div v-bind:class="errors.social_accounts ? 'form-group has-error' : 'form-group'">
                                <label>
                                    <input type="checkbox" v-model="plan.attributes.social_accounts">
                                    Social accounts
                                </label>
                                <span class="help-block" v-if="errors.social_accounts">
                                    <div v-for="error in errors.social_accounts">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                            <div v-bind:class="errors.builder ? 'form-group has-error' : 'form-group'">
                                <label>
                                    <input type="checkbox" v-model="plan.attributes.builder">
                                    Fan Base Building Tools
                                </label>
                                <span class="help-block" v-if="errors.builder">
                                    <div v-for="error in errors.builder">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                            <div v-bind:class="errors.support ? 'form-group has-error' : 'form-group'">
                                <label>
                                    <input type="checkbox" v-model="plan.attributes.support">
                                    Advanced support
                                </label>
                                <span class="help-block" v-if="errors.support">
                                    <div v-for="error in errors.support">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div v-bind:class="errors.enabled ? 'form-group has-error' : 'form-group'">
                        <label>
                            <input type="checkbox" v-model="plan.attributes.enabled">
                            Enabled <small>(This option is responsible for displaying the plan on the site)</small>
                        </label>
                        <span class="help-block" v-if="errors.enabled">
                            <div v-for="error in errors.enabled">
                                <strong v-text="error"></strong>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="ladda-button btn btn-primary" data-style="expand-right" v-on:click="save($event)">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['plan'],
        watch: {
            'value': function(value) {
                this.$emit('input', value);
            }
        },
        data: function() {
            return {
                errors: []
            };
        },
        mounted: function () {
            var vm = this;
            $(this.$el).on('show.bs.modal, hide.bs.modal', function() {
                vm.errors = [];
            });
        },
        methods: {
            save: function(event) {
                var button = $(event.target).ladda();
                this.errors = [];
                var vm = this;
                button.ladda('start');
                this.plan.save(function(plan){
                    button.ladda('stop');
                    vm.$emit('success', plan);
                }, function(error){
                    if(error.response.status == 422) {
                        vm.errors = error.response.data;
                    }
                    vm.$emit('error', error);
                    button.ladda('stop');
                });
            }
        }
    }
</script>
