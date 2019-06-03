@extends('admin.layouts.main')
@section('title', 'Edit SOrder ' . $order->id)
@section('content')
<div id="admin-order-edit" data-id="{{ $order->id }}">
    <div class="row" v-if="form.attributes.id">
        <div class='col-md-3'>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Info</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label>Customer</label>
                        <a v-bind:href="form.attributes.customer.getEditUrl()" v-text="form.attributes.customer.getFullname()"></a>
                    </div>
                    <div v-bind:class="'form-group'+(errors.amount? ' has-error' : '')">
                        <label>Amount</label>
                        <input v-model="form.attributes.amount" type="text" class="form-control">
                        <span class="help-block" v-if="errors.amount">
                            <div v-for="error in errors.amount"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                    <div v-bind:class="'form-group'+(errors.payment_type? ' has-error' : '')">
                        <label>Payment Type</label>
                        <select class="form-control" v-model="form.attributes.payment_type">
                            <option v-bind:value="'stripe'" v-bind:selected="form.attributes.payment_type == 'stripe'">Stripe</option>
                            <option v-bind:value="'paypal'" v-bind:selected="form.attributes.payment_type == 'paypal'">Paypal</option>
                        </select>
                        <span class="help-block" v-if="errors.payment_type">
                            <div v-for="error in errors.payment_type"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                    <div v-bind:class="'form-group'+(errors.order_status? ' has-error' : '')">
                        <label>Order Status</label>
                        <select class="form-control" v-model="form.attributes.order_status">
                            <option v-bind:value="'pending'" v-bind:selected="form.attributes.order_status == 'pending'">Pending</option>
                            <option v-bind:value="'declined'" v-bind:selected="form.attributes.order_status == 'declined'">Declined</option>
                            <option v-bind:value="'refunded'" v-bind:selected="form.attributes.order_status == 'refunded'">Refunded</option>
                            <option v-bind:value="'paid'" v-bind:selected="form.attributes.order_status == 'paid'">Paid</option>
                        </select>
                        <span class="help-block" v-if="errors.order_status">
                            <div v-for="error in errors.order_status"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Created At</label>
                        <span v-text="form.attributes.created_at ? form.attributes.created_at.format('MMMM DD, YYYY HH:mm:ss') : ''"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 v-text="!form.attributes.items.isEmpty() ? 'Posts' : (form.attributes.story ? 'Story' : 'Info')"></h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group" v-if="!form.attributes.items.isEmpty()">
                        <table class="table table-hover" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item</th>
                                    <th>License</th>
                                    <th>Price</th>
                                    <th>Commission Amount</th>
                                    <th>Stripe Charge</th>
                                    <th>Stripe Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="orderItem in form.attributes.items.getData()">
                                    <td v-text="orderItem.get('id')"></td>
                                    <td v-text="orderItem.get('item').get('name')" v-bind:href="orderItem.get('item').getEditUrl()"></td>
                                    <td v-text="orderItem.get('license').get('name')"></td>
                                    <td v-text="orderItem.get('price')"></td>
                                    <td v-text="orderItem.get('commission_amount')"></td>
                                    <td v-text="orderItem.get('stripe_charge_id')"></td>
                                    <td v-text="orderItem.get('stripe_status')"></td>
                                    <td v-text="orderItem.get('created_at') ? orderItem.get('created_at').format('MMMM DD, YYYY') : ''"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else-if="form.attributes.story">
                        <div class="form-group">
                            <label>ID</label>
                            <span v-text="form.get('story').get('id')"></span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <span v-text="form.get('story').get('price')"></span>
                        </div>
                        <div class="form-group">
                            <label>Stripe Charge</label>
                            <span v-text="form.get('story').get('stripe_charge_id')"></span>
                        </div>
                        <div class="form-group">
                            <label>Stripe Status</label>
                            <span v-text="form.get('story').get('stripe_status')"></span>
                        </div>
                        <div class="form-group">
                            <label>Available</label>
                            <span><i v-bind:class="'fa fa-' + (form.get('story').get('is_available') ? 'check' : 'times')"></i></span>
                        </div>
                        <div class="form-group">
                            <label>Created</label>
                            <span v-text="form.get('story').get('created_at') ? form.get('story').get('created_at').format('MMMM DD, YYYY') : ''"></span>
                        </div>
                    </div>
                    <div class="form-group" v-else>
                        <label>Order doesn't contain any items or story</label>
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
                <a href="/control/order/list" class="btn btn-info btn-block">
                    Go Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection