@extends('admin.layouts.main')
@section('title', 'Edit Affiliate Sale ' . $sale->id)
@section('content')

<div id="admin-affiliate-sale-edit" data-id="{{ $sale->id }}">
    <div class="row" v-if="form.attributes.id">
        <div class='col-md-offset-3 col-md-6'>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Info</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label>Username</label>
                        <a v-bind:href="form.attributes.user.getEditUrl()" v-text="form.attributes.user.get('username')"></a>
                    </div>
                    <div class="form-group">
                        <label>Order Item ID</label>
                        <span v-text="form.attributes.order_item_id"></span>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <span v-text="form.attributes.amount"></span>
                    </div>
                    <div class="form-group">
                        <label>Request ID</label>
                        <a v-bind:href="form.attributes.request_id ? ('/control/affiliate/request/' + form.attributes.request_id + '/edit') : '#'"
                           v-text="form.attributes.request_id">
                        </a>
                    </div>
                    <div class="form-group">
                        <label>Created At</label>
                        <span v-text="form.attributes.created_at ? form.attributes.created_at.format('MMMM DD, YYYY HH:mm:ss') : ''"></span>
                    </div>
                    <div v-bind:class="'form-group'+(errors.is_closed ? ' has-error' : '')">
                        <label>Paid</label>
                        <input v-model="form.attributes.is_paid" type="checkbox">
                        <span class="help-block" v-if="errors.is_paid">
                            <div v-for="error in errors.is_paid"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-2">
            <div class="form-group">
                <button v-on:click="submit($event)" type="submit" class="btn btn-primary btn-block">
                    Save
                </button>
            </div>
        </div>
        <div class="col-md-3 col-md-offset-2">
            <div class="form-group">
                <a href="/control/affiliate/sales" class="btn btn-info btn-block">
                    Go Back
                </a>
            </div>
        </div>
    </div>
</div>

@endsection