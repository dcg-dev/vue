@extends('layouts.main')
@section('title', 'Settings')
@section('subtitle', 'Manage your account')
@section('content')
    @include('profile.topbar')
    <div class="content content-boxed hide" id="profile-settings">
        <!-- Settings -->
        <div class="block">
            <ul class="nav nav-tabs nav-justified push-20" data-toggle="tabs">
                <li v-bind:class="tab == 'general' ? 'active' : '' " v-on:click="tab = 'general'">
                    <a href="javascript:void(0)"><i class="fa fa-fw fa-pencil"></i>
                        General
                        <small v-if="errors.email || errors.firstname || errors.lastname || errors.country || errors.company || errors.gender || errors.accepted"
                               class="text-danger">(has
                            errors)
                        </small>
                    </a>
                </li>
                <li v-bind:class="tab == 'address' ? 'active' : '' " v-on:click="tab = 'address'">
                    <a href="javascript:void(0)"><i class="fa fa-fw fa-home"></i>
                        Address Details
                        <small v-if="errors.address_1 || errors.address_2 || errors.city || errors.state"
                               class="text-danger">(has
                            errors)
                        </small>
                    </a>
                </li>
                <li v-bind:class="tab == 'password' ? 'active' : '' " v-on:click="tab = 'password'">
                    <a href="javascript:void(0)"><i class="si si-key"></i>
                        Password
                        <small v-if="errors.current_password || errors.new_password || errors.new_password_confirmation"
                               class="text-danger">(has
                            errors)
                        </small>
                    </a>
                </li>
                <li v-bind:class="tab == 'options' ? 'active' : '' " v-on:click="tab = 'options'">
                    <a href="javascript:void(0)"><i class="si si-settings"></i>
                        Payment Options
                        <small v-if="errors.stripe_account_id"
                               class="text-danger">(has
                            errors)
                        </small>
                    </a>
                </li>
                <li v-bind:class="tab == 'privacy' ? 'active' : '' " v-on:click="tab = 'privacy'">
                    <a href="javascript:void(0)"><i class="fa fa-fw fa-lock"></i>
                        Privacy
                        <small v-if="errors.show_status || errors.notification_release || errors.notification_sale || errors.notification_inbox || errors.notification_comments || errors.notification_reviews"
                               class="text-danger">(has
                            errors)
                        </small>
                    </a>
                </li>
            </ul>

            <div class="block-content tab-content">
                <!-- General Tab -->
                <div v-show="tab == 'general'" id="tab-bd-settings-general">
                    <div class="row items-push">
                        <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label>Username</label>
                                    <div class="form-control-static font-w700" v-text="form.username"></div>
                                </div>
                            </div>
                            <div v-bind:class="'form-group'+(errors.email ? ' has-error' : '')">
                                <div class="col-xs-12">
                                    <label for="bd-settings-email">Email <span class="text-danger">*</span></label>
                                    <input class="form-control input-lg" type="text" id="val-email"
                                           placeholder="Enter your valid email.." v-model="form.email">
                                    <span class="help-block" v-if="errors.email">
                                    <div v-for="error in errors.email"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <div v-bind:class="'form-group'+(errors.firstname ? ' has-error' : '')">
                                <div class="col-xs-12">
                                    <label for="val-firstname">First Name <span class="text-danger">*</span></label>
                                    <input class="form-control input-lg" type="text" id="val-firstname"
                                           placeholder="Enter your first name.." v-model="form.firstname">
                                    <span class="help-block" v-if="errors.firstname">
                                    <div v-for="error in errors.firstname"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <div v-bind:class="'form-group'+(errors.lastname ? ' has-error' : '')">
                                <div class="col-xs-12">
                                    <label for="val-lastname">Last Name <span class="text-danger">*</span></label>
                                    <input class="form-control input-lg" id="val-lastname"
                                           placeholder="Enter your last name.." type="text" v-model="form.lastname">
                                    <span class="help-block" v-if="errors.lastname">
                                    <div v-for="error in errors.lastname"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <div v-bind:class="'form-group'+(errors.country ? ' has-error' : '')">
                                <div class="col-xs-12">
                                    <label for="val-country">Country <span class="text-danger">*</span></label>
                                    <countries v-model="form.country"></countries>
                                    <span class="help-block" v-if="errors.country">
                                    <div v-for="error in errors.country"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <div v-bind:class="'form-group'+(errors.company ? ' has-error' : '')">
                                <div class="col-xs-12">
                                    <label for="bd-settings-company-name">Company Name</label>
                                    <input class="form-control input-lg" id="bd-settings-company"
                                           placeholder="Enter your company name.." type="text" v-model="form.company">
                                    Leave empty if no company.
                                    <span class="help-block" v-if="errors.company">
                                    <div v-for="error in errors.company"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <div v-bind:class="'form-group'+(errors.gender ? ' has-error' : '')">
                                <label class="col-xs-12">Gender</label>
                                <div class="col-xs-12">
                                    <label class="css-input css-radio css-radio-primary push-10-r">
                                        <input type="radio" name="gender" v-model="form.gender"
                                               value="female"><span></span> Female
                                    </label>
                                    <label class="css-input css-radio css-radio-primary">
                                        <input type="radio" name="gender" v-model="form.gender"
                                               value="male"><span></span> Male
                                    </label>
                                    <span class="help-block" v-if="errors.gender">
                                    <div v-for="error in errors.gender"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <div v-bind:class="'form-group'+(errors.accepted ? ' has-error' : '')">
                                <label class="col-xs-12">Terms <span class="text-danger">*</span></label>
                                <div class="col-xs-12">
                                    <label class="css-input css-checkbox css-checkbox-primary" for="val-terms">
                                        <input id="val-terms" v-model="form.accepted" type="checkbox"><span></span> I
                                        agree to the terms
                                    </label>
                                    <span class="help-block" v-if="errors.accepted">
                                    <div v-for="error in errors.accepted"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END General Tab -->
                <!-- Address Tab -->
                <div v-show="tab == 'address'" id="tab-bd-settings-address">
                    <div class="row items-push">
                        <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                            <div class="form-group">
                                <div class="form-control-static col-xs-12">
                                    <label>Address Details</label>
                                    <div class="font-w400">If you want to sell items you must state your address details
                                        as it's requested by law.
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label>First Name</label>
                                    <div class="form-control-static font-w700" v-text="form.firstname"></div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Last Name</label>
                                    <div class="form-control-static font-w700" v-text="form.lastname"></div>
                                </div>
                            </div>
                            <div class="form-group">

                            </div>
                            <div v-bind:class="'form-group'+(errors.address_1 ? ' has-error' : '')">
                                <div class="col-xs-12">
                                    <label for="bd-settings-street">Street Name</label>
                                    <input class="form-control input-lg" id="bd-settings-name"
                                           placeholder="Enter your street name..." type="text" v-model="form.address_1">
                                    <span class="help-block" v-if="errors.address_1">
                                    <div v-for="error in errors.address_1"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <div v-bind:class="'form-group'+(errors.address_2 ? ' has-error' : '')">
                                <div class="col-xs-12">
                                    <label for="bd-settings-street2">Street Name 2</label>
                                    <input class="form-control input-lg" id="bd-settings-name"
                                           placeholder="Enter your street name.." type="text" v-model="form.address_2">
                                    <span class="help-block" v-if="errors.address_2">
                                    <div v-for="error in errors.address_2"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <div v-bind:class="'form-group'+(errors.city ? ' has-error' : '')">
                                <div class="col-xs-12">
                                    <label for="bd-settings-city">City</label>
                                    <input class="form-control input-lg" id="bd-settings-city"
                                           placeholder="Enter your city.." type="text" v-model="form.city">
                                    <span class="help-block" v-if="errors.city">
                                    <div v-for="error in errors.city"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <div v-bind:class="'form-group'+(errors.state ? ' has-error' : '')">
                                <div class="col-xs-12">
                                    <label for="bd-settings-state">State / Canton</label>
                                    <input class="form-control input-lg" id="bd-settings-state"
                                           placeholder="Enter your state.." type="text" v-model="form.state">
                                    <span class="help-block" v-if="errors.state">
                                    <div v-for="error in errors.state"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label>Country</label>
                                    <div class="form-control-static font-w700" v-text="form.country"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Address Tab -->
                <!-- Password Tab -->
                <div v-show="tab == 'password'" id="tab-bd-settings-password">
                    <div class="row items-push">
                        <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                            <div v-bind:class="'form-group'+(errors.current_password ? ' has-error' : '')"
                                 v-if="!form.is_empty_password">
                                <div class="col-xs-12">
                                    <label for="val-password" for="val-password">Current Password</label>
                                    <input class="form-control input-lg" id="val-password" type="password"
                                           v-model="form.current_password">
                                    <span class="help-block" v-if="errors.current_password">
                                    <div v-for="error in errors.current_password"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <hr v-if="!form.is_empty_password">
                            <div v-bind:class="'form-group'+(errors.new_password ? ' has-error' : '')">
                                <div class="col-xs-12">
                                    <label for="val-new-password">New Password</label>
                                    <input class="form-control input-lg" id="val-new-password" type="password"
                                           v-model="form.new_password">
                                    <span class="help-block" v-if="errors.new_password">
                                    <div v-for="error in errors.new_password"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <div v-bind:class="'form-group'+(errors.new_password_confirmation ? ' has-error' : '')">
                                <div class="col-xs-12">
                                    <label for="val-confirm-password">Confirm New Password</label>
                                    <input class="form-control input-lg" id="val-confirm-password" type="password"
                                           v-model="form.new_password_confirmation">
                                    <span class="help-block" v-if="errors.new_password_confirmation">
                                    <div v-for="error in errors.new_password_confirmation"><strong
                                                v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Password Tab -->
                <!-- Seller Settings Tab -->
                <div v-show="tab == 'options'" id="tab-bd-payment-options">
                    <div class="row items-push">
                        <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                            <h4 class="font-w400">Payment options</h4>
                            <h6 class="text-muted push-30">Set your payment options to receive payments</h6>
                            <div class="col-xs-12 push-30">
                                <img src="{{ asset('images/logos/paypal.jpg') }}" alt="" border="0" width="123"
                                     height="122"> <br>
                                <p class="badge badge-success font-w400">Paypal Payment Active</p><br>
                                <label class="push-20-t" for="val-email">Paypal Email</label>
                                <input class="form-control input-lg" id="val-email" v-model="form.paypal_email"
                                       placeholder="Enter your paypal email.." type="text">
                            </div>
                            <div v-bind:class="'col-xs-12 push-30 form-group'+(errors.stripe_account_id ? ' has-error' : '')">
                                <div :class="!currentUser.canUsePro() ? 'disabled' : ''">
                                    <img src="{{ asset('images/logos/stripe.jpg') }}" alt="" border="0" width="134"
                                         height="69"> <br>
                                    <p v-bind:class="'badge badge-' + (form.hasStripe && currentUser.canUsePro() ? 'success' : 'default') + ' font-w400'"
                                       v-text="'Stripe Payment ' + (form.hasStripe && currentUser.canUsePro() ? 'Active' : 'is disabled')">
                                    </p>
                                    <br>
                                    <label class="push-20-t">Stripe Account
                                        <badge v-if="currentUser.canUsePro()" class="badge badge-success-modern">PRO
                                        </badge>
                                        <badge v-if="!currentUser.canUsePro()" class="badge badge-muted">PRO</badge>
                                    </label>
                                    <div>
                                        <a v-if="currentUser.canUsePro()"
                                           href="{{ route('oauth', ['profiver' => 'stripe']) }}"
                                           class="btn btn-noborder btn-lg btn-primary" type="submit"
                                           v-text="form.stripe_account_id ? 'Update' : 'Attach'">
                                        </a>
                                        <p v-text="'Your current account' + (form.stripe_account_id && currentUser.canUsePro() ? ': ' + form.stripe_account_id : ' was not attached.')"></p>
                                    </div>
                                    <input v-model="form.stripe_account_id" hidden type="text">
                                    <span class="help-block" v-if="errors.stripe_account_id">
                                <div v-for="error in errors.stripe_account_id"><strong v-text="error"></strong></div>
                            </span>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
                <!-- END Seller Settings Tab -->
                <!-- Privacy Tab -->
                <div v-show="tab == 'privacy'" id="tab-bd-settings-privacy">
                    <div class="row items-push">
                        <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                            <div v-bind:class="'form-group'+(errors.show_status ? ' has-error' : '')">
                                <div class="col-xs-8">
                                    <div class="font-s13 font-w600">Online Status</div>
                                    <div class="font-s13 font-w400 text-muted">Show your status to all</div>
                                    <span class="help-block" v-if="errors.show_status">
                                    <div v-for="error in errors.show_status"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <label class="css-input switch switch-sm switch-primary push-10-t">
                                        <input v-model="form.show_status" type="checkbox"><span></span>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div v-bind:class="'form-group'+(errors.notification_release ? ' has-error' : '')">
                                <div class="col-xs-8">
                                    <div class="font-s13 font-w600">Notification Release</div>
                                    <div class="font-s13 font-w400 text-muted">Notify me if my item got released or
                                        declined.
                                    </div>
                                    <span class="help-block" v-if="errors.notification_release">
                                    <div v-for="error in errors.notification_release"><strong
                                                v-text="error"></strong></div>
                                </span>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <label class="css-input switch switch-sm switch-primary push-10-t">
                                        <input v-model="form.notification_release" type="checkbox"><span></span>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div v-bind:class="'form-group css-'+(errors.notification_sale ? ' has-error' : '')">
                                <div class="col-xs-8">
                                    <div class="font-s13 font-w600">Notification Sale <label
                                                class="label label-default font-w400 badge-xs">Pro</label></div>
                                    <div class="font-s13 font-w400 text-muted">Notify me if my item got sold.</div>
                                    <span class="help-block" v-if="errors.notification_sale">
                                    <div v-for="error in errors.notification_sale"><strong
                                                v-text="error"></strong></div>
                                </span>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <label v-bind:class="'css-input ' + (!currentUser.canUsePro() ? 'css-input-disabled' : '') + ' switch switch-sm switch-primary push-10-t'">
                                        <input v-bind:disabled="!currentUser.canUsePro()"
                                               v-model="form.notification_sale"
                                               type="checkbox"><span></span>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div v-bind:class="'form-group'+(errors.notification_inbox ? ' has-error' : '')">
                                <div class="col-xs-8">
                                    <div class="font-s13 font-w600">Notification Inbox <label
                                                class="label label-default font-w400 badge-xs">Pro</label></div>
                                    <div class="font-s13 font-w400 text-muted">Notify me if I got a new message.</div>
                                    <span class="help-block" v-if="errors.notification_inbox">
                                    <div v-for="error in errors.notification_inbox"><strong
                                                v-text="error"></strong></div>
                                </span>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <label v-bind:class="'css-input ' + (!currentUser.canUsePro() ? 'css-input-disabled' : '') + ' switch switch-sm switch-primary push-10-t'">
                                        <input v-bind:disabled="!currentUser.canUsePro()"
                                               v-model="form.notification_inbox"
                                               type="checkbox"><span></span>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div v-bind:class="'form-group'+(errors.notification_comments ? ' has-error' : '')">
                                <div class="col-sm-8">
                                    <div class="font-s13 font-w600">Notification Comments <label
                                                class="label label-default font-w400 badge-xs">Pro</label></div>
                                    <div class="font-s13 font-w400 text-muted">Notify me if someone left a comment on my
                                        item.
                                    </div>
                                    <span class="help-block" v-if="errors.notification_comments">
                                    <div v-for="error in errors.notification_comments"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <label v-bind:class="'css-input ' + (!currentUser.canUsePro() ? 'css-input-disabled' : '') + ' switch switch-sm switch-primary push-10-t'">
                                        <input v-bind:disabled="!currentUser.canUsePro()"
                                               v-model="form.notification_comments"
                                               type="checkbox"><span></span>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div v-bind:class="'form-group'+(errors.notification_reviews ? ' has-error' : '')">
                                <div class="col-sm-8">
                                    <div class="font-s13 font-w600">Notification Reviews <label
                                                class="label label-default font-w400 badge-xs">Pro</label></div>
                                    <div class="font-s13 font-w400 text-muted">Notify me if someone left a review on my
                                        item.
                                    </div>
                                    <span class="help-block" v-if="errors.notification_reviews">
                                    <div v-for="error in errors.notification_reviews"><strong
                                                v-text="error"></strong></div>
                                </span>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <label v-bind:class="'css-input ' + (!currentUser.canUsePro() ? 'css-input-disabled' : '') + ' switch switch-sm switch-primary push-10-t'">
                                        <input v-bind:disabled="!currentUser.canUsePro()"
                                               v-model="form.notification_reviews"
                                               type="checkbox"><span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Privacy Tab -->
            </div>
            <div class="block-content block-content-full bg-gray-lighter text-center">
                <button class="btn btn-noborder btn-lg btn-success-modern" type="submit"
                        v-on:click="updateSettings($event)">
                    <i class="fa fa-check push-5-r"></i>Update
                </button>
            </div>
        </div>
        <!-- END Main Content -->
    </div>
@endsection