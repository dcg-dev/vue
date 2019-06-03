if (document.getElementById('admin-promotional-list')) {
    window.adminPromotionalList = new Vue({
        el: '#admin-promotional-list',
        data: {
            collection: new Collection(),
            loading: false,
            search: null,
            columns: [{key: 'stripe_plan', title: 'Plan'},
                    {key: 'created_at', title: 'Created At'},
                    {key: 'ends_at', title: 'Ends At'}],
            sortKey: 'created_at',
            sortPromotional: {}
        },
        mounted: function () {
            var that = this;
            //initialize sorting asc/desc
            this.columns.forEach(function (column) {
                that.sortPromotional[column.key] = -1;
            });
            this.getList(); 
        },
        methods: {
            getList: function() {
                this.loading = true;
                var that = this;
                promoSubscriptions().all(function(collection) {
                    adminPromotionalList.collection = collection;
                    adminPromotionalList.loading = false;
                }, function() {
                    adminPromotionalList.collection = new Collection();
                    adminPromotionalList.loading = false;
                }, Object.assign({
                    'q': that.search,
                    'order': [that.sortKey + '|' + (that.sortPromotional[that.sortKey] > 0 ? 'asc' : 'desc')],
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
                this.sortPromotional[key] *= -1;
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