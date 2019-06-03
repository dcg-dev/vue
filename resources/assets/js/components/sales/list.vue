<template>
    <div class="block" :class="{'block-opt-refresh': loading}">
        <div class="block-header">
            <ul class="block-options">
                <li>
                    <button type="button" data-toggle="block-option" data-action="refresh_toggle"
                            data-action-mode="demo" v-on:click.prevent="load"><i class="si si-refresh"></i></button>
                </li>
            </ul>
            <h4 class="font-w300">Sales</h4>
        </div>
        <div v-if="items.length > 0">
            <!--<div class="block-content block-content-full bg-gray-lighter text-center">-->
            <!--<div class="btn-group">-->
            <!--<button class="btn btn-sm btn-default" type="submit">Last 30 days</button>-->
            <!--<button class="btn btn-sm btn-default" type="submit">Last 6 months</button>-->
            <!--<button class="btn btn-sm btn-default" type="submit">Last year</button>-->
            <!--</div>-->
            <!--</div>-->
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter table-header-bg">
                        <thead>
                        <tr>
                            <td class="text-left text-white" style="width: 200px;"><span class="font-w600 text-white">Date</span>
                            </td>
                            <td style="width: 100px;"><span class="font-w600 text-white">Order</span></td>
                            <td>
                                <span class="font-w600 text-white">Item</span>
                            </td>
                            <td class="text-left" style="width: 100px;">
                                <a class="font-w600 text-white" href="javascript:void(0)">Buyer</a>
                            </td>
                            <td class="text-left" style="width: 100px;">
                                <span class="font-w600 text-white">Total</span>
                            </td>
                            <td class="text-right">
                                <span class="font-w600 text-white">Country</span>
                            </td>
                            <td class="text-left">
                                <span class="font-w600 text-white" id="vat_question" data-placement="top"
                                      data-content="This info shows you how much VAT you will need to pay. Learn more at our support center.">
                                    <i class="si si-question"></i> VAT.
                                </span>
                            </td>
                            <td class="text-right" style="width: 80px;">
                                <span class="font-w600 text-white">Commission</span>
                            </td>
                            <td class="text-right" style="width: 80px;">
                                <span class="font-w600 text-white">Amount</span>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in items">
                            <td class="text-left text-muted" style="width: 200px;"
                                v-text="item.get('created_at').format('MMM DD, Y')"></td>
                            <td style="width: 100px;"><a href="#">#ID{{ item.get('order_id') }}</a></td>
                            <td>
                                <a class="font-w600" :href="'/item/' + item.get('item').get('slug')"
                                   v-text="item.get('item').get('name')"></a>
                            </td>
                            <td class="text-left" style="width: 200px;">
                                <span class="font-w600" v-text="item.get('item').get('creator').getFullname()"></span>
                            </td>
                            <td class="text-left">
                                <span class="font-w400">{{ item.get('price') | currency }}</span>
                            </td>
                            <td class="text-right">
                                <div v-if="item.get('country')">
                                    <span v-text="item.get('country')"></span>
                                    <span v-if="item.get('vat')">
                                        (VAT {{item.getVat()}}%)
                                    </span>
                                </div>
                            </td>
                            <td class="text-left">
                                <span class="font-w600 text-default"
                                      v-if="item.get('item').get('creator').get('country_info')">${{item.get('item').get('creator').get('country_info').calculateVat(item.get('price', 0))}}</span>
                            </td>
                            <td class="text-left" style="width: 80px;">
                                <span class="font-w600 text-muted">{{ item.get('commission_amount') | currency }}</span>
                            </td>
                            <td class="text-right" style="width: 80px;">
                                <span class="font-w600 text-success">{{ (item.get('price') - item.get('commission_amount')) | currency
                                    }}</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center push">
                    <button class="btn btn-sm btn-default" type="button" data-size="sm" data-style="expand-right"
                            v-on:click.prevent="more($event)" :disabled="collection.isLastPage()">
                        <i class="fa fa-arrow-down push-5-r text-primary"></i>Load More..
                    </button>
                </div>
            </div>
        </div>
        <div class="text-center" v-if="items.length == 0">
            <div class="block-content block-content-full">
                You did not have any sales yet.
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                page: 1,
                loading: false,
                collection: new Collection(),
                items: [],
                button: null,
                loadMore: true
            };
        },
        props: {},
        mounted: function () {
            this.load();
        },
        methods: {
            load: function () {
                this.loading = true;
                var vm = this;

                this.setPage(1);

                order_items().all(function (list) {
                    vm.collection = list;
                    vm.items = vm.collection.getData();
                    vm.loading = false;
                    vm.$nextTick(function () {
                        $('#vat_question').popover({
                            container: 'body',
                            animation: true,
                            trigger: 'hover'
                        });
                    });
                }, function () {
                    vm.loading = false;
                }, queryString.parse(location.search));
            },
            more: function (event) {
                var vm = this;

                this.setPage(this.page + 1);


                order_items().all(function (list) {
                    vm.collection = list;
                    vm.items = vm.items.concat(vm.collection.getData());
                }, function () {
                }, queryString.parse(location.search));
            },
            setPage: function (page) {
                this.page = page;

                var query = queryString.parse(location.search);
                query.page = this.page;
                history.pushState(null, null, location.origin + location.pathname + '?' + queryString.stringify(query, {arrayFormat: 'index'}));
            }
        }
    }
</script>