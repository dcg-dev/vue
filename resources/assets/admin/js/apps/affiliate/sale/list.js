if (document.getElementById('admin-affiliate-sale-list')) {
    window.adminAffiliateSaleList = new Vue({
        el: '#admin-affiliate-sale-list',
        data: {
            collection: new Collection(),
            loading: false,
            search: null,
            columns: [{key: 'id', title: 'ID'},
                    {key: 'order_item_id', title: 'Order Item ID'},
                    {key: 'amount', title: 'Amount'},
                    {key: 'request_id', title: 'Request ID'},
                    {key: 'created_at', title: 'Created At'}],
            sortKey: 'id',
            sortOrders: {}
        },
        mounted: function () {
            var that = this;
            //initialize sorting asc/desc
            this.columns.forEach(function (column) {
                that.sortOrders[column.key] = -1;
            });
            this.getList(); 
        },
        methods: {
            getList: function() {
                this.loading = true;
                var that = this;
                affiliate_sales().sales(function(collection){
                    that.collection = collection;
                    that.loading = false;
                }, function() {
                    that.collection = new Collection();
                    that.loading = false;
                }, Object.assign({
                    'order': [that.sortKey + '|' + (that.sortOrders[that.sortKey] > 0 ? 'asc' : 'desc')],
                }, queryString.parse(location.search)));
            },
            page: function() {
                this.getList();
            },
            sortBy: function(key) {
                this.sortKey = key;
                this.sortOrders[key] *= -1;
                this.getList();
            }
        },
    });
}