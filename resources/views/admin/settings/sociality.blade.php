@extends('admin.layouts.main')
@section('title', 'Social Networks')
@section('content')
<form role="form" method="POST" action="{{ route('admin.settings.store') }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Links</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label>Facebook</label>
                        <input type="text" name="facebook_link" class="form-control" value="{{Setting::get('facebook.link')}}">
                    </div>
                    <div class="form-group">
                        <label>Twitter</label>
                        <input type="text" name="twitter_link" class="form-control" value="{{Setting::get('twitter.link')}}">
                    </div>
                    <div class="form-group">
                        <label>Google Plus</label>
                        <input type="text" name="google_link" class="form-control" value="{{Setting::get('google.link')}}">
                    </div>
                    <div class="form-group">
                        <label>SoundCloud</label>
                        <input type="text" name="soundcloud_link" class="form-control" value="{{Setting::get('soundcloud.link')}}">
                    </div>
                    <div class="form-group">
                        <label>Youtube</label>
                        <input type="text" name="youtube_link" class="form-control" value="{{Setting::get('youtube.link')}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Facebook</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label>App ID</label>
                        <input type="text" name="facebook_id" class="form-control" value="{{config('services.facebook.client_id')}}">
                    </div>
                    <div class="form-group">
                        <label>Secret</label>
                        <input type="text" name="facebook_secret" class="form-control" value="{{config('services.facebook.client_secret')}}">
                    </div>
                    <div class="form-group">
                        <label>Redirect url</label>
                        <input type="text" name="facebook_redirect" class="form-control" value="{{config('services.facebook.redirect')}}">
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
