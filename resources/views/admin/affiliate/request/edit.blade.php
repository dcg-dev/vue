@extends('admin.layouts.main')
@section('title', 'Edit Affiliate Request ' . $request->id)
@section('content')

<div id="admin-affiliate-request-edit" data-id="{{ $request->id }}">
    <div class="row" v-if="form.attributes.id">
        <div class='col-md-4'>
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
                        <label>Created At</label>
                        <span v-text="form.attributes.created_at.format('MMMM DD, YYYY HH:mm:ss')"></span>
                    </div>
                    <div v-bind:class="'form-group'+(errors.message ? ' has-error' : '')">
                        <label>Message</label>
                        <textarea class="form-control" v-model="form.attributes.message"></textarea>
                        <span class="help-block" v-if="errors.message">
                            <div v-for="error in errors.message"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                    <div v-bind:class="'form-group'+(errors.is_closed ? ' has-error' : '')">
                        <label>Closed</label>
                        <input v-model="form.attributes.is_closed" type="checkbox">
                        <span class="help-block" v-if="errors.is_closed">
                            <div v-for="error in errors.is_closed"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Closed At</label>
                        <span v-text="form.attributes.closed_at ? form.attributes.closed_at.format('MMMM DD, YYYY HH:mm:ss') : ''"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Affiliate Sales</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover" v-if="!form.attributes.affiliate_sales.isEmpty()">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Order Item ID</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sale in form.attributes.affiliate_sales.getData()">
                                <td><a v-bind:href="sale.getEditUrl('sale')" v-text="sale.get('id')"></a></td>
                                <td v-text="sale.get('order_item_id')"></td>
                                <td v-text="sale.get('amount')"></td>
                                <td><i v-bind:class="'fa fa-' + (sale.get('is_paid') ? 'check text-success' : 'times text-danger')"></i></td>
                                <td v-text="sale.get('created_at').format('MMMM DD, YYYY')"></td>
                            </tr>
                        </tbody>
                    </table>
                    <span v-else>Affiliate Request doesn't contain any Affiliate Sale</span>
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
                <a href="/control/affiliate/requests" class="btn btn-info btn-block">
                    Go Back
                </a>
            </div>
        </div>
    </div>
</div>

@endsection