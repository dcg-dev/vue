if (document.getElementById('admin-order-list')) {
    window.adminOrderList = new Vue({
        el: '#admin-order-list',
        data: {
            collection: new Collection(),
            loading: false,
            search: null,
            columns: [{key: 'id', title: 'ID'},
                    {key: 'amount', title: 'Amount'},
                    {key: 'payment_type', title: 'Payment Type'},
                    {key: 'order_status', title: 'Order Status'},
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
                orders().adminList(function(collection) {
                    adminOrderList.collection = collection;
                    adminOrderList.loading = false;
                }, function() {
                    adminOrderList.collection = new Collection();
                    adminOrderList.loading = false;
                }, Object.assign({
                    'q': that.search,
                    'order': [that.sortKey + '|' + (that.sortOrders[that.sortKey] > 0 ? 'asc' : 'desc')],
                    'relations': [
                        'customer'
                    ]
                }, queryString.parse(location.search)));
            },
            page: function() {
                this.getList();
            },
            sortBy: function(key) {
                this.sortKey = key;
                this.sortOrders[key] *= -1;
                this.getList();
            },
            deleteOrder: function(order) {
                var that = this;
                swal({
                    title: "Delete order?",
                    text: order.get('subject'),
                    type: 'error',
                    confirmButtonColor: "#88c5e0",
                    confirmButtonText: "Delete",
                    showCancelButton: true
                }, function() {
                    that.loading = true;
                    order.delete(function() {
                        toastr.info('Order has been deleleted.');
                        that.loading = false;
                        that.getList();
                    }, function () {
                        toastr.error('Error happened during order deleting.');
                        that.loading = false;
                    });
                });
            },
        },
    });
}