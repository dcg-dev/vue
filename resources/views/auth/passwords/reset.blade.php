@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')
    <div id="reset-password-page" class="bg-image" style="background-image: url('http://ec2-34-234-83-192.compute-1.amazonaws.com/images/headers/roqpianobg.jpg'); overflow-y: hidden;">
        <form-alert v-if="successShow"
                    message="Your password has been reset!"></form-alert>
        <div class="content content-boxed push-3">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                    <div class="push-65-t push-100 bg-white content animated fadeIn">
                        <!-- Reminder Title -->
                        <div class="text-center">
                            <h1 class="h1 font-w300 push-15-t">Forgot Password?</h1>
                            <p class="font-s18 text-muted">Don't worry, well send a reset link to you.</p>
                        </div>
                        <div class="alert alert-danger fade in alert-dismissable" v-if="errors.token">
                            <div v-for="error in errors.token" v-text="error"></div>
                        </div>
                        <form class="js-validation-reminder form-horizontal push-30-t" method="post">
                            <div class="form-group" :class="{ 'has-error':  errors.email}">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating"
                                         :class="{ open:  form.email}">
                                        <input class="form-control" id="email" type="email" v-model="form.email">
                                        <label for="email">Enter Your Email</label>
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
                                    <div class="form-material form-material-primary floating"
                                         :class="{ open:  form.password}">
                                        <input class="form-control" id="password" type="password"
                                               v-model="form.password">
                                        <label for="password">Choose a new strong password..</label>
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
                                    <div class="form-material form-material-primary floating"
                                         :class="{ open:  form.password_confirmation}">
                                        <input id="password-confirm" class="form-control" type="password"
                                               v-model="form.password_confirmation">
                                        <label for="password-confirm">..and confirm it</label>
                                        <span class="help-block" v-if="errors.password_confirmation">
                                        <div v-for="error in errors.password_confirmation">
                                            <strong v-text="error"></strong>
                                        </div>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                                    <button class="btn btn-lg btn-block btn-primary" data-style="zoom-in"
                                            v-on:click.prevent="submit($event)">Reset Password
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- END Reminder Form -->

                        <!-- Extra Links -->
                        <div class="text-center push-50-t push-30">
                            <a href="/login">Login?</a>
                        </div>
                        <!-- END Extra Links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection