@extends('admin.layouts.main')
@section('title', 'Social Networks')
@section('content')
    <form role="form" method="POST" action="{{ route('admin.settings.store') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Black list of email providers <small>Add providers from a new line</small></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <textarea type="text" name="firewall_cewl" class="form-control"
                                      rows="10">{{Setting::get('firewall.cewl')}}</textarea>
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
