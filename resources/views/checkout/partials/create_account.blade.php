<div class="block" v-if="!currentUser">
    <div class="block-header">
        <h5 class="block-title font-w300">2. Create Account</h5>
    </div>
    <div class="block-content">
        <div class="row">
            <div class="col-sm-6">
                <div v-bind:class="'form-group'+(errors.username ? ' has-error' : '')">
                    <div class="col-xs-12">
                        <div class="form-material floating">
                            <input v-model="form.username" class="form-control" id="checkout-username" name="checkout-username" type="text">
                            <label for="checkout-username">Username</label>
                        </div>
                        <span class="help-block" v-if="errors.username">
                            <div v-for="error in errors.username"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
                <div v-bind:class="'form-group'+(errors.email ? ' has-error' : '')">
                    <div class="col-xs-12">
                        <div class="form-material floating">
                            <input v-model="form.email" class="form-control" id="checkout-email" name="checkout-email" type="email">
                            <label for="checkout-email">Email</label>
                        </div>
                        <span class="help-block" v-if="errors.email">
                            <div v-for="error in errors.email"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
                <div v-bind:class="'form-group'+(errors.password ? ' has-error' : '')">
                    <div class="col-xs-12">
                        <div class="form-material floating">
                            <input v-model="form.password" class="form-control" id="checkout-password" name="checkout-password" type="password">
                            <label for="checkout-password">Password</label>
                        </div>
                        <span class="help-block" v-if="errors.password">
                            <div v-for="error in errors.password"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
                <div v-bind:class="'form-group'+(errors.password_confirmation ? ' has-error' : '')">
                    <div class="col-xs-12">
                        <div class="form-material floating">
                            <input v-model="form.password_confirmation" class="form-control" id="checkout-password2" name="checkout-password2" type="password">
                            <label for="checkout-password2">Confirm Password</label>
                        </div>
                        <span class="help-block" v-if="errors.password_confirmation">
                            <div v-for="error in errors.password_confirmation"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div v-bind:class="'form-group'+(errors.firstname ? ' has-error' : '')">
                    <div class="col-xs-12">
                        <div class="form-material floating">
                            <input v-model="form.firstname" class="form-control" id="checkout-firstname" name="checkout-firstname" type="text">
                            <label for="checkout-firstname">Firstname</label>
                        </div>
                        <span class="help-block" v-if="errors.firstname">
                            <div v-for="error in errors.firstname"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
                <div v-bind:class="'form-group'+(errors.lastname ? ' has-error' : '')">
                    <div class="col-xs-12">
                        <div class="form-material floating">
                            <input v-model="form.lastname" class="form-control" id="checkout-lastname" name="checkout-lastname" type="text">
                            <label for="checkout-lastname">Lastname</label>
                        </div>
                        <span class="help-block" v-if="errors.lastname">
                            <div v-for="error in errors.lastname"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
                <div v-bind:class="'form-group'+(errors.country ? ' has-error' : '')">
                    <div class="col-xs-12">
                        <div class="form-material floating">
                            <input v-model="form.country" class="form-control" id="checkout-country" name="checkout-country" type="text">
                            <label for="checkout-country">Country</label>
                        </div>
                        <span class="help-block" v-if="errors.country">
                            <div v-for="error in errors.country"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
                <div v-bind:class="'form-group'+(errors.city ? ' has-error' : '')">
                    <div class="col-xs-12">
                        <div class="form-material floating">
                            <input v-model="form.city" class="form-control" id="checkout-city" name="checkout-city" type="text">
                            <label for="checkout-city">City</label>
                        </div>
                        <span class="help-block" v-if="errors.city">
                            <div v-for="error in errors.city"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>