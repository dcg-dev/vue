<template>
    <div class="bg-white text-center">
        <div class="row  block block-content">
            <!--licenses-->
            <div v-if="!item.isFree()">
                <span class="font-s36 font-w600 push-30">$<span
                        v-text="license ? license.getPrice(item.getPrice()) : item.getPrice()"></span></span><br>
                <div class="btn-group licenses push-10">
                    <a class="font-s18 font-w600 push-30 dropdown-toggle" data-toggle="dropdown" href="#">
                        <span v-text="license.get('name')"></span> License <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu padding">
                        <li v-for="licen in item.get('licenses').getData()">
                            <a href="#" v-on:click.prevent="setLicense(licen)">
                                <h5>
                                    <span class="pull-left" v-text="licen.get('name')"></span>
                                    <span class="pull-right text-success">$<span
                                            v-text="licen.getPrice(item.getPrice())"></span></span>
                                    <div class="clearfix"></div>
                                </h5>
                                <div class="text-muted font-w300" v-text="licen.get('description', '')"></div>
                            </a>
                        </li>
                    </ul>
                </div>
                <br/>
                <button v-if="!item.get('inCart') && !isBoughtLicense(license.get('id'))"
                        v-on:click="addItemToCart($event)" data-style=""
                        class="btn btn-lg btn-success-modern btn-block push-20 js-swal-continue-shopping">Buy now
                </button>
                <button v-if="item.get('inCart') && !isBoughtLicense(license.get('id'))" disabled
                        class="btn btn-lg btn-modern-success btn-block push-20">Already in Cart
                </button>
            </div>
            <div v-if="item.isFree()">
                <span class="font-s36 font-w600 push-30"><span v-text="'Free'"></span></span><br v-if="item.isFree()">
                <div v-if="item.isNeedFollow() && !item.get('creator').iFollow()">
                    <p class="text-muted">Please, follow me if you want to download this item.</p>
                    <button disabled="true" class="btn btn-lg btn-success-modern btn-block push-20">Download</button>
                </div>
            </div>
            <a v-if="(item.isFree() && !currentUser && !item.isNeedFollow()) || (item.isFree() && item.isNeedFollow() && item.get('creator').iFollow()) || (item.isFree() && !item.isNeedFollow()) || isBoughtLicense(license.get('id'))"
               v-bind:href="item.get('file')"
               class="btn btn-lg btn-success-modern btn-block push-20 js-swal-continue-shopping">Download
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        props: {
            item: {
                required: true
            },
            license: {
                required: true
            }
        },
        computed: {
            currentUser: function () {
                return currentUser;
            }
        },
        mounted: function () {
        },
        methods: {
            setLicense: function (license) {
                this.$parent.setLicense(license);
            },
            addItemToCart: function (event) {
                this.$parent.addItemToCart(event);
            },
            isBoughtLicense: function (licenseId) {
                //check if the license ID was bought already
                return _.includes(this.item.get('boughtLicenses'), licenseId);
            }
        }
    }
</script>