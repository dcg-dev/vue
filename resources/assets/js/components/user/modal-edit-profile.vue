<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Missing information</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info text-center">
                        To create an item and start selling, we do not have enough information about you. Please fill out all the displayed fields in this form.
                    </div>
                    <form @submit.prevent="save($event)">
                        <div class="form-group" :class="{'has-error':errors.firstname.length}"
                             v-if="!user.get('firstname')">
                            <label>First name</label>
                            <input type="text" class="form-control" v-model="form.firstname" required>
                            <div class="help-block" v-if="errors.firstname">
                                <div v-for="error in errors.firstname">
                                    <strong v-text="error"></strong>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error':errors.lastname.length}"
                             v-if="!user.get('lastname')">
                            <label>Last name</label>
                            <input type="text" class="form-control" v-model="form.lastname" required>
                            <div class="help-block" v-if="errors.lastname">
                                <div v-for="error in errors.lastname">
                                    <strong v-text="error"></strong>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error':errors.country.length}"
                             v-if="!user.get('country')">
                            <label>Country</label>
                            <countries v-model="form.country"></countries>
                            <div class="help-block" v-if="errors.country">
                                <div v-for="error in errors.country">
                                    <strong v-text="error"></strong>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error':errors.city.length}"
                             v-if="!user.get('city')">
                            <label>City</label>
                            <input type="text" class="form-control" v-model="form.city" required>
                            <div class="help-block" v-if="errors.city">
                                <div v-for="error in errors.city">
                                    <strong v-text="error"></strong>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error':errors.state.length}"
                             v-if="!user.get('state')">
                            <label>State / Canton</label>
                            <input type="text" class="form-control" v-model="form.state" required>
                            <div class="help-block" v-if="errors.state">
                                <div v-for="error in errors.state">
                                    <strong v-text="error"></strong>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error':errors.address_1.length}"
                             v-if="!user.get('address_1')">
                            <label>Street Name</label>
                            <input type="text" class="form-control" v-model="form.address_1" required>
                            <div class="help-block" v-if="errors.address_1">
                                <div v-for="error in errors.address_1">
                                    <strong v-text="error"></strong>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error':errors.paypal_email.length}"
                             v-if="!user.get('paypal_email')">
                            <label>Paypal email</label>
                            <input type="email" class="form-control" v-model="form.paypal_email">
                            <div class="help-block" v-if="errors.paypal_email">
                                <div v-for="error in errors.paypal_email">
                                    <strong v-text="error"></strong>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-lg btn-success-modern">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    firstname: '',
                    lastname: '',
                    country: '',
                    paypal_email: '',
                    address_1: [],
                    city: [],
                    state: [],
                },
                errors: {
                    firstname: [],
                    lastname: [],
                    country: [],
                    paypal_email: [],
                    address_1: [],
                    city: [],
                    state: [],
                }
            }
        },
        props: {
            user: {
                required: true
            }
        },
        methods: {
            prepare: function () {
                for (let key in this.form) {
                    if (this.user.get(key)) {
                        this.form[key] = this.user.get(key);
                    }
                }
            },
            save: function (event) {
                this.prepare();
                let promise = axios.post('/api/profile/update/intersect', this.form);
                this.errors = {
                    firstname: [],
                    lastname: [],
                    country: [],
                    paypal_email: [],
                    address_1: [],
                    city: [],
                    state: [],
                };
                promise.then((response) => {
                    this.user.setAttributes(response.data);
                    $(this.$el).modal('hide');
                    this.$emit('done', this.user);
                });
                promise.catch((error) => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data;
                    }
                });
            },
        }
    }
</script>