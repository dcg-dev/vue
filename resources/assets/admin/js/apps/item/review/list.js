if (document.getElementById('admin-review-list')) {
    window.adminReviewList = new Vue({
        el: '#admin-review-list',
        data: {
            collection: new Ratings(),
            loading: false,
            search: null,
            modal: new Rating(),
            errors: {
                modal: {}
            },
            columns: [
                {key: 'review', title: 'Review'},
                {key: 'creator_id', title: 'Creator'},
                {key: 'item_id', title: 'Item'},
                {key: 'created_at', title: 'Created At'}],
            sortKey: 'created_at',
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
            getList: function () {
                this.loading = true;
                var that = this;
                ratings().adminList(function (collection) {
                    adminReviewList.collection = collection;
                    adminReviewList.loading = false;
                }, function () {
                    adminReviewList.loading = false;
                }, Object.assign({
                    'relations': [
                        'item',
                    ],
                    'q': that.search,
                    'order': [that.sortKey + '|' + (that.sortOrders[that.sortKey] > 0 ? 'asc' : 'desc')]
                }, queryString.parse(location.search)));
            },
            page: function () {
                this.getList();
            },
            sortBy: function (key) {
                this.sortKey = key;
                this.sortOrders[key] *= -1;
                this.getList();
            },
            edit: function (item) {
                this.modal = item;
                $('#edit-modal').modal('show');
            },
            update: function (event) {
                var that = this;
                var button = $(event.target).ladda();
                button.ladda('start');
                this.modal.save('/control/api/rating/' + this.modal.get('id'), function () {
                    button.ladda('stop');
                    that.getList();
                    $('#edit-modal').modal('hide');
                }, function () {
                    button.ladda('stop');
                });
            },
            deleteItem: function (item) {
                var that = this;
                swal({
                    title: "Delete rating?",
                    text: item.get('name'),
                    type: 'error',
                    confirmButtonColor: "#88c5e0",
                    confirmButtonText: "Delete",
                    showCancelButton: true
                }, function () {
                    that.loading = true;
                    item.delete(function () {
                        toastr.info('Rating has been deleleted.');
                        that.loading = false;
                        that.getList();
                    }, function () {
                        toastr.error('Error happened during rating deleting.');
                        that.loading = false;
                    });
                });
            },
        },
    });
}