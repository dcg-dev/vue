if (document.getElementById('affiliate-sales')) {
    window.affiliateSales = new Vue({
        el: '#affiliate-sales',
        data: {
            currentUser: false,
            list: new Collection(),
            info: {},
            isPaidFilter: null,
            loading: false,
            dateFilter: 'month',
            button: null
        },
        mounted: function () {
            this.currentUser = currentUser;
            this.getList();
            this.getInfo();
        },
        methods: {
            getList: function () {
                var that = this;
                that.loading = true;
                affiliate_sales().all(function (list) {
                    that.list = list;
                    that.loading = false;
                }, function () {
                    that.list = new Collection();
                    toastr.error('Error has occured during affiliate sales obtaining', 'Affiliate Sales');
                    that.loading = false;
                }, {
                    'page': 1,
                    'per_page': 10,
                    'is_paid': that.isPaidFilter,
                    'date_filter': that.dateFilter,
                    'order': [
                        'created_at|desc'
                    ],
                });
            },
            getInfo: function () {
                var that = this;
                affiliate_sales().info(function (info) {
                    that.info = info;
                }, function () {
                    that.info = {};
                    toastr.error('Error has occured during affiliate sales info obtaining', 'Affiliate Sales');
                });
            },
            changePaidFilter: function (status) {
                this.isPaidFilter = status;
                this.getList();
            },
            changeDateFilter: function (type) {
                this.dateFilter = type;
                this.getList();
            },
            modalRequest: function () {
                $('#modal-request').modal('toggle');
            },
            madeRequest: function () {
                this.modalRequest();
                this.errors = [];
                users().current(function(user) {
                    affiliateSales.currentUser = user;
                }, function() {
                    affiliateSales.currentUser = false;
                }, true);
            }
        },
    });
}