<template>
    <div class="block" :class="{'block-opt-refresh': loading}">
        <div class="block-header">
            <ul class="block-options">
            <li>
                <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo" v-on:click.prevent="load"><i class="si si-refresh"></i></button>
                </li>
            <li class="dropdown">
                <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter: {{ type ? (type) : 'all' }}<span class="caret"></span></button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <a tabindex="-1" href="javascript:void(0)" v-on:click.prevent="load()"><span class="badge pull-right">{{ total }}</span>All</a>
                    </li>
                    <li>
                        <a tabindex="-1" href="javascript:void(0)" v-on:click.prevent="load('account')"><span class="badge pull-right">{{ account }}</span>Account</a>
                    </li>
                    <li>
                        <a tabindex="-1" href="javascript:void(0)" v-on:click.prevent="load('promotional')"><span class="badge pull-right">{{ promotional }}</span>Promotional</a>
                    </li>
                    </ul>
                </li>
            </ul>
            <h4 class="text-black-op font-w400">Subscriptions & Billing</h4>
        </div>
        <div class="block-content">
            <div v-if="items.length > 0" class="table-responsive">
                <table  class="table table-hover table-vcenter">
                    <tbody>
                    <tr v-for="item in items">
                        <td width="150" class="text-muted" v-text="item.get('updated_at').format('DD MMM, YYYY')"></td>
                        <td width="300" v-text="'ID: ' + item.get('order_id')"></td>
                        <td class="font-w600" v-text="item.get('description')"></td>
                        <td width="150" class="font-w600" v-text="item.get('user')"></td>
                        <td width="150" :class="'text-right font-w600' + (item.get('price') < 0 ? ' text-success' : '')">
                            <span v-if="item.get('price') < 0">+</span>{{ (item.get('price')*-1) | currency }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center push">
                    <button class="btn btn-xs btn-default-modern" type="button" data-size="xs" v-on:click.prevent="more($event)" :disabled="!loadMore">
                        <i class="fa fa-arrow-down push-5-r text-primary"></i>Load More..
                    </button>
                </div>
            </div>
            <div v-if="!loading && items.length == 0" class="alert alert-warning">You have not received any invoices yet.</div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                page: 1,
                loading: false,
                invoices: [],
                items: [],
                button: null,
                loadMore: true,
                type: null,
                account: 0,
                promotional: 0,
                total: 0
            }
        },
        mounted: function () {
            this.load();

            var query = queryString.parse(location.search);
            this.type = query.type;
        },
        methods: {
            load: function (type) {
                this.loading = true;
                var vm = this;

                this.setPage(1);

                this.type = type;

                var query = queryString.parse(location.search);
                query.type = this.type;
                history.pushState(null, null, location.origin + location.pathname + '?' +queryString.stringify(query,{arrayFormat: 'index'}));

                order_items().billing(function(list) {
                    vm.items = list.getData();
                    vm.account = list.account;
                    vm.promotional = list.promotional;
                    vm.total = list.total;
                    vm.loading = false;
                }, function() {
                    vm.loading = false;
                }, queryString.parse(location.search));
            },
            more: function (event) {
                var vm = this;

                this.setPage(this.page + 1);


                order_items().billing(function(list) {
                    if (list.getData().length < 10) {
                        vm.items = vm.items.concat(list.getData());
                        vm.loadMore = false;
                    } else {
                        vm.items = vm.items.concat(list.getData());
                    }
                }, function() {
                }, queryString.parse(location.search));
            },
            setPage: function(page) {
                this.page = page;

                var query = queryString.parse(location.search);
                query.page = this.page;
                history.pushState(null, null, location.origin + location.pathname + '?' +queryString.stringify(query,{arrayFormat: 'index'}));
            }


            /*load: function () {
                this.loading = true;
                order_items().billing(function(list) {
                    vm.collection = list;
                    vm.items = vm.items.concat(vm.collection.getData());
                    vm.button.stop();
                }, function() {
                    vm.button.stop();
                }, queryString.parse(location.search));

                this.get().then((response) => {
                    this.invoices = response.data;
                    this.loading = false;
                }, (error) => {
                    this.loading = false;
                });
            },
            get: function () {
                return axios.get('/api/billing/invoices?page=' + this.page);
            },
            more: function () {
                this.page += 1;
                if(!this.button) {
                    this.button = Ladda.create(event.target);
                }
                this.button.start();
                this.get().then((response) => {
                    if (response.data.length == 0) {
                        this.loadMore = false;
                    } else {
                        this.invoices = this.invoices.concat(response.data);
                    }

                    this.button.stop();
                }, (error) => {
                    this.button.stop();
                });
            }*/
        },
    }
</script>
