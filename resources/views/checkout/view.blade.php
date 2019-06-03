@extends('layouts.main')
@section('title', 'Checkout')
@section('subtitle', 'You are almost there')
@section('content')
    @include('checkout.partials.header')
    <div class="content content-boxed overflow-hidden" id="checkout-view">
        <!-- Checkout Content -->
        <section class="content content-boxed">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2" v-if="cart && cart.info.items.length">
                    <!-- Card plugin (.js-card-form and .js-card-container are initialized at the bottom of the page) -->
                    <!-- For more info and examples you can check out https://github.com/jessepollak/card -->
                    <div class="js-card-form form-horizontal">
                        <!-- Products -->
                        <div class="block">
                            <div class="block-header">
                                <h5 class="block-title font-w300">1. Products
                                </h5></div>
                            <div id="cart-content" class="block-content">
                                <form-alert v-if="successShow"
                                            message="Item has been removed from the cart."></form-alert>
                                <table class="table table-borderless table-vcenter">
                                    <tbody>
                                    <tr v-for="item in cart.info.items">
                                        <td style="max-width: 55px;" class="text-center">
                                            <a v-on:click="removeItemFromCart(item.attributes.get('slug'))"
                                               class="text-danger" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                                        </td>
                                        <td style="width: 55px;">
                                            <img class="img-responsive" v-bind:src="item.attributes.get('image')"
                                                 alt="">
                                        </td>
                                        <td>
                                            <a class="h5" v-bind:href="item.attributes.getUrl()"
                                               v-text="item.attributes.get('name')"></a>
                                        </td>
                                        <td class="text-right">
                                            <div v-if="item.attributes.get('creator').get('country_info').get('vat')" class="font-w600 text-success" v-text="'$' + item.attributes.get('creator').get('country_info').getPriceWithoutVat(item.price)"></div>
                                            <div v-if="!item.attributes.get('creator').get('country_info').get('vat')" class="font-w600 text-success" v-text="'$' + item.price"></div>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-light">
                                        <td class="text-right" colspan="3">
                                            <span class="h5 font-w600">Subtotal</span>
                                        </td>
                                        <td class="text-right">
                                            <div class="h4 font-w600 text-gray-dark"
                                                 v-text="'$' + cart.info.subtotal"></div>
                                        </td>
                                    </tr>
                                    <tr class="bg-lighter" v-if="cart.info.vat.percentage > 0">
                                        <td class="text-right" colspan="3">
                                            <span class="h5 font-w600">VAT. @{{ cart.info.vat.percentage}}%</span>
                                        </td>
                                        <td class="text-right">
                                            <div class="h4 font-w600 text-gray-dark">$@{{ cart.info.vat.total}}</div>
                                        </td>
                                    </tr>
                                    <tr class="success">
                                        <td class="text-right" colspan="3">
                                            <span class="h4 font-w600">Total</span>
                                        </td>
                                        <td class="text-right">
                                            <div class="h4 font-w600 text-success" v-text="'$' + cart.info.total"></div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END Products -->

                        <!-- Create Account -->
                        <div class="text-center visible-xs">
                            <p>Already have an account? <a href="/">Login here</a>.</p>
                        </div>
                    @include('checkout.partials.create_account')
                    <!-- END Create Account -->

                        <!-- Choose Payment Provider -->
                    @include('checkout.partials.choose_payment')
                    <!-- END Choose Payment Provider -->

                        <!-- Credit Card -->
                    @include('checkout.partials.credit_card')
                    <!-- END Credit Card -->
                    </div>
                </div>
                <div class="col-sm-8 col-sm-offset-2 empty-collection" v-else>
                    <div class="block">
                        <div class="block-content text-center">
                            <p>There are no items in your cart.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END Checkout Content -->
    </div>
@endsection