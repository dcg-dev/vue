if (document.getElementById('admin-subscription-list')) {
    window.adminSubscriptionList = new Vue({
        el: '#admin-subscription-list',
        data: {
            collection: new Collection(),
            loading: false,
            search: null,
            columns: [{key: 'stripe_plan', title: 'Plan'},
                    {key: 'created_at', title: 'Created At'}],
            sortKey: 'created_at',
            sortSubscriptions: {}
        },
        mounted: function () {
            var that = this;
            //initialize sorting asc/desc
            this.columns.forEach(function (column) {
                that.sortSubscriptions[column.key] = -1;
            });
            this.getList(); 
        },
        methods: {
            getList: function() {
                this.loading = true;
                var that = this;
                subscriptions().all(function(collection) {
                    adminSubscriptionList.collection = collection;
                    adminSubscriptionList.loading = false;
                }, function() {
                    adminSubscriptionList.collection = new Collection();
                    adminSubscriptionList.loading = false;
                }, Object.assign({
                    'q': that.search,
                    'order': [that.sortKey + '|' + (that.sortSubscriptions[that.sortKey] > 0 ? 'asc' : 'desc')],
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
                this.sortSubscriptions[key] *= -1;
                this.getList();
            },
            cancel: function(subscription) {
                var that = this;
                swal({
                    title: "Cancel subscription?",
                    text: subscription.get('plan'),
                    type: 'error',
                    confirmButtonColor: "#88c5e0",
                    confirmButtonText: "Yes",
                    showCancelButton: true
                }, function() {
                    that.loading = true;
                    subscription.cancel(function() {
                        toastr.info('Subscription has been canceled.');
                        that.loading = false;
                        that.getList();
                    }, function () {
                        toastr.error('Error happened during subscription canceling.');
                        that.loading = false;
                    });
                });
            },
        },
    });
}