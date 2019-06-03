<template>
    <!-- Products -->
    <div class="block block-rounded" :class="{'block-opt-refresh': loading}">
        <div class="block-content">
            <div v-if="items.length > 0" class="table-responsive">
                <table class="table table-hover table-vcenter">
                    <tbody>
                    <tr v-for="item in items">
                        <td class="text-center" style="width: 200px;">
                            <div style="width: 180px;">
                                <img class="img-responsive" v-bind:src="item.get('item').get('image')" alt="">
                            </div>
                        </td>
                        <td>
                            <a v-bind:title="item.get('item').get('name')" v-bind:href="item.get('item').getUrl()"><h4 v-text="item.get('item').get('name')"></h4></a>
                            <a class="font-w600" v-bind:href="item.get('item').get('creator').getUrl()" v-text="item.get('item').get('creator').getFullname()"></a>
                            <p class="remove-margin-b">
                                <stars :rating="item.get('item').get('rating', 0)"></stars>
                            </p>
                            <p class="remove-margin-b push-10-t">Purchased: <span class="text-gray-dark" v-text="item.get('updated_at').format('DD MMM, Y')"></span></p>
                            <p class="remove-margin-b">License: <span class="text-gray-dark" v-text="item.get('license').get('name')"></span></p>
                            <!--<p class="remove-margin-b">Payment: <span class="text-gray-dark">Paypal</span></p>-->
                        </td>
                        <td>
                            <a class="btn btn-sm btn-default" type="button" :href="'/billing/invoice/' + item.get('order_id')">
                                <i class="fa fa-print push-5-r text-primary"></i>Print Invoice
                            </a>
                            <span class="btn btn-sm btn-default" v-on:click.prevent="rateOpen(item)"><i class="fa fa-pencil push-5-r text-success"></i> Rate Item</span>
                        </td>
                        <td class="text-center">
                            <div class="h1 font-w700 text-gray">{{ item.get('price') | currency }}</div>
                            <a :href="'/item/' + item.get('item').get('slug') + '/download/product'" class="btn btn-s btn-success-modern push-10-t">
                                <i class="fa fa-download push-5-r text-white"></i>Download
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center push">
                    <button class="btn btn-xs btn-default-modern" type="button" data-size="xs" data-style="expand-right"
                            v-on:click.prevent="more($event)" :disabled="collection.isLastPage()">
                        <i class="fa fa-arrow-down push-5-r text-primary"></i>Load More..
                    </button>
                </div>
                <rate id="modal-rate" ref="rate" v-on:submitted="rateSubmitted"></rate>
            </div>
            <div v-if="items.length == 0 && !loading" class="text-center panel text-muted">
                You do not have purchased items yet.
            </div>
        </div>
    </div>
    <!-- END Products -->
</template>
<script>
  export default {
    data: function() {
        return {
            page: 1,
            loading: false,
            collection: new Collection(),
            items: [],
            button: null,
            loadMore: true
        };
    },
    props: ['invoice-route'],
    mounted: function () {
        this.load();
    },
    methods: {
        load: function () {
            this.loading = true;
            var vm = this;

            //this.setPage(1);

            order_items().purchased(function(list) {
                vm.collection = list;
                vm.items = vm.collection.getData();
                vm.loading = false;
            }, function() {
                vm.loading = false;
            }, queryString.parse(location.search));
        },
        more: function (event) {
            var vm = this;
            this.setPage(this.page + 1);
            order_items().purchased(function(list) {
                vm.collection = list;
                vm.items = vm.items.concat(vm.collection.getData());
            }, function() {
            }, queryString.parse(location.search));
        },
        setPage: function(page) {
            this.page = page;

            var query = queryString.parse(location.search);
            query.page = this.page;
            history.pushState(null, null, location.origin + location.pathname + '?' +queryString.stringify(query,{arrayFormat: 'index'}));
        },
        rateOpen: function(item) {
            this.$refs.rate.setItem(item);
            this.rateToogle();
        },
        rateSubmitted: function () {
            this.rateToogle();
        },
        rateToogle: function () {
            $('#modal-rate').modal('toggle');
        }
    }
}
</script>