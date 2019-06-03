@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    <div id="login-page" class="bg-image" style="background-image: url('http://ec2-34-234-83-192.compute-1.amazonaws.com/images/headers/roqpianobg.jpg'); overflow-y: auto;">
        <div class="content content-boxed push-20">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <div class="push-65-t push-100 bg-white content">
                        <div class="text-center push-20">
                            <h1 class="h1 font-w300 push-15-t">Login</h1>
                            <span class="text-muted">Good to see you again.</span>
                        </div>
                        <div class="row push-10-t push-5">
                            <div class="col-md-12">
                                <a href="{{route('oauth',['profiver' => 'facebook'])}}"
                                   class="btn btn-primary btn-block"><i class="fa fa-facebook"></i> Login via
                                    facebook</a>
                            </div>
                        </div>
                        <form class="js-validation-login form-horizontal push-30-t" method="post">
                            <div class="form-group" :class="{ 'has-error':  errors.email}">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating"
                                         :class="{ open:  form.email}">
                                        <input class="form-control" type="email" id="login-username"
                                               v-model="form.email">
                                        <label for="login-username">Email</label>
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
                                        <input class="form-control" type="password" id="login-password"
                                               v-model="form.password">
                                        <label for="login-password">Password</label>
                                        <span class="help-block" v-if="errors.password">
                                        <div v-for="error in errors.password">
                                            <strong v-text="error"></strong>
                                        </div>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label class="css-input switch switch-sm switch-primary text-muted font-w300">
                                        <input type="checkbox" id="login-remember-me"
                                               v-model="form.remember"><span></span> Remember Me?
                                    </label>
                                </div>
                                <div class="col-xs-6">
                                    <div class="font-s13 text-right text-gray-light push-5-t">
                                        <a href="/password/reset">Forgot Password?</a><br>
                                        <a href="/register" class="text-gray font-w600">Register</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group push-30-t">
                                <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                    <button class="ladda-button btn btn-lg btn-block btn-success-modern" data-style=""
                                            v-on:click.prevent="submit($event)"> Login
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- END Login Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection