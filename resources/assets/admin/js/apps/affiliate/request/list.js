if (document.getElementById('admin-affiliate-request-list')) {
    window.adminAffiliateRequestList = new Vue({
        el: '#admin-affiliate-request-list',
        data: {
            collection: new Collection(),
            loading: false,
            search: null,
            columns: [{key: 'id', title: 'ID'},
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
                affiliate_sales().requests(function(collection){
                    that.collection = collection;
                    that.loading = false;
                }, function() {
                    that.collections = new Collection();
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
            },
            closeRequest: function(request) {
                var that = this;
                swal({
                    title: "Close this affiliate request?",
                    text: null,
                    type: 'error',
                    confirmButtonColor: "#88c5e0",
                    confirmButtonText: "Close",
                    showCancelButton: true,
                }, function() {
                    that.loading = true;
                    request.closeRequest(function() {
                        toastr.info('Affiliate Request has been closed.');
                        that.loading = false;
                    }, function () {
                        toastr.error('Error happened during Affilite Request closing.');
                        that.loading = false;
                    });
                });
            }
        },
    });
}