@extends('admin.layouts.main')
@section('title', 'Notifications')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>SMTP</h5>
            </div>
            <div class="ibox-content">
                <form role="form" method="POST" action="{{ route('admin.settings.store') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Domain</label>
                        <input type="text" name="notification_mailgun_domain" class="form-control" value="{{config('services.mailgun.domain')}}">
                    </div>
                    <div class="form-group">
                        <label>Secret</label>
                        <input type="text" name="notification_mailgun_secret" class="form-control" value="{{config('services.mailgun.secret')}}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>From Name</label>
                                <input type="text" name="notification_from_name" class="form-control" value="{{config('mail.from.name')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>From Address</label>
                                <input type="text" name="notification_from_address" class="form-control" value="{{config('mail.from.address')}}">
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
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Test email</h5>
            </div>
            <div class="ibox-content">
                <form role="form" method="POST" action="{{ route('admin.settings.email') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>To</label>
                        <input type="text" name="to" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" class="form-control" rows="11"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Send
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
