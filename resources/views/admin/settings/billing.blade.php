@extends('admin.layouts.main')
@section('title', 'Billing')
@section('content')
<form role="form" method="POST" action="{{ route('admin.settings.store') }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Stripe</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label>Publishable</label>
                        <input type="text" name="stripe_key" class="form-control" value="{{Setting::get('stripe.key')}}">
                    </div>
                    <div class="form-group">
                        <label>Secret</label>
                        <input type="text" name="stripe_secret" class="form-control" value="{{Setting::get('stripe.secret')}}">
                    </div>
                    <div class="form-group">
                        <label>Client ID</label>
                        <input type="text" name="stripe_id" class="form-control" value="{{Setting::get('stripe.id')}}">
                    </div>
                    <div class="form-group">
                        <label>Redirect URIs</label>
                        <input type="text" name="stripe_redirect" class="form-control" value="{{Setting::get('stripe.redirect')}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Paypal</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label>UserName</label>
                        <input type="text" name="paypal_username" class="form-control" value="{{Setting::get('paypal.username')}}">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" name="paypal_password" class="form-control" value="{{Setting::get('paypal.password')}}">
                    </div>
                    <div class="form-group">
                        <label>Signature</label>
                        <input type="text" name="paypal_signature" class="form-control" value="{{Setting::get('paypal.signature')}}">
                    </div>
                    <div class="form-group">
                        <label>App ID</label>
                        <input type="text" name="paypal_appid" class="form-control" value="{{Setting::get('paypal.appid')}}">
                    </div>
                    <div class="form-group">
                        <label>Primary receiver</label>
                        <input type="text" name="paypal_email" class="form-control" value="{{Setting::get('paypal.email')}}" placeholder="Email">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="hidden" name="paypal_sandbox" value="0">
                            <input type="checkbox" name="paypal_sandbox" value="1" {{Setting::get('paypal.sandbox') ? ' checked' : ''}}> Sandbox Mode
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-primary btn-block">
                    Save
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
