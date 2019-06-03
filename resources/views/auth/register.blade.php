@extends('layouts.auth')
@section('title', 'Register')
@section('content')
    <div id="register-page" class="bg-image" style="background-image: url('http://ec2-34-234-83-192.compute-1.amazonaws.com/images/headers/roqpianobg.jpg'); overflow-y: auto;">
        <form-alert v-if="successShow"
                    message="Register successfully! You need to confirm your account. We have sent you an activation link, please check your email."></form-alert>
        <div class="content content-boxed push-20">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                    <div class="push-10-t push-15 bg-white content">
                        <!-- Register Title -->
                        <div class="text-center">
                            <h1 class="h1 font-w300">Create Account</h1>
                            <div class="h5 font-w400 text-muted">Join our community of music producers.</div>
                            <div class="text-gray push-20-t">Already have an account? <a href="/login"
                                                                                         class="font-w400 text-gray"><b>Login
                                        here</b></a></div>
                        </div>
                        <!-- END Register Title -->

                        <!-- Register Form -->
                        <!-- jQuery Validation (.js-validation-register class is initialized in js/pages/base_pages_register.js) -->
                        <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <div class="js-validation-register form-horizontal push-50-t push-50">
                            <div class="form-group" :class="{ 'has-error':  errors.username}">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-success">
                                        <input class="form-control" type="text" placeholder="Please enter your username"
                                               v-model="form.username">
                                        <label for="register-username">Username</label>
                                        <span class="help-block" v-if="errors.username">
                                        <div v-for="error in errors.username">
                                            <strong v-text="error"></strong>
                                        </div>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" :class="{ 'has-error':  errors.email}">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-success">
                                        <input class="form-control" type="email" placeholder="Please provide your email"
                                               v-model="form.email">
                                        <label for="register-email">Email</label>
                                        <span class="help-block" v-if="errors.email">
                                        <div v-for="error in errors.email">
                                            <strong v-text="error"></strong>
                                        </div>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" :class="{ 'has-error':  errors.password}">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-success">
                                        <input class="form-control" type="password"
                                               placeholder="Choose a strong password.." v-model="form.password">
                                        <label for="register-password">Password</label>
                                        <span class="help-block" v-if="errors.password">
                                        <div v-for="error in errors.password">
                                            <strong v-text="error"></strong>
                                        </div>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" :class="{ 'has-error':  errors.password_confirmation}">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-success">
                                        <input class="form-control" type="password" placeholder="..and confirm it"
                                               v-model="form.password_confirmation">
                                        <label for="register-password2">Confirm Password</label>
                                        <span class="help-block" v-if="errors.password_confirmation">
                                        <div v-for="error in errors.password_confirmation">
                                            <strong v-text="error"></strong>
                                        </div>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" :class="{ 'has-error':  errors.accepted}">
                                <div class="col-xs-7 col-sm-8">
                                    <label class="css-input switch switch-sm switch-success">
                                        <input type="checkbox" v-model="form.accepted"><span></span> I agree with terms
                                        &amp; conditions
                                    </label>
                                    <span class="help-block" v-if="errors.accepted">
                                    <div v-for="error in errors.accepted">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                                </div>
                                <div class="col-xs-5 col-sm-4">
                                    <div class="font-s13 text-right push-5-t">
                                        <a href="#" data-toggle="modal" data-target="#modal-terms">View Terms</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                                    <button class="btn btn-lg btn-block btn-success" data-style="zoom-in"
                                            v-on:click.prevent="submit($event)">Create Account
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- END Register Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection