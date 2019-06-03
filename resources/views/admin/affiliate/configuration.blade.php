@extends('admin.layouts.main')
@section('title', 'Affiliate Configuration')
@section('content')
<form role="form" method="POST" action="{{ route('admin.settings.store') }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Affiliate Sales</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label>Referral Percent for items</label>
                        <input type="number" name="referral_percent_items" class="form-control" value="{{Setting::get('referral.percent.items')}}">
                    </div>
                    <div class="form-group">
                        <label>Referral Percent for subscriptions</label>
                        <input type="number" name="referral_percent_subscriptions" class="form-control" value="{{Setting::get('referral.percent.subscriptions')}}">
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
