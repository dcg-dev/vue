if (document.getElementById('admin-comment-list')) {
    window.adminCommentList = new Vue({
        el: '#admin-comment-list',
        data: {
            collection: new Comments(),
            loading: false,
            search: null,
            modal: new Comment(),
            errors: {
                modal: {}
            },
            columns: [
                {key: 'message', title: 'Comment'},
                {key: 'sender_id', title: 'Creator'},
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
                comments().adminList(function (collection) {
                    adminCommentList.collection = collection;
                    adminCommentList.loading = false;
                }, function () {
                    adminCommentList.loading = false;
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
                this.modal.save('/control/api/comment/' + this.modal.get('id'), function () {
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
                    title: "Delete comment?",
                    text: item.get('name'),
                    type: 'error',
                    confirmButtonColor: "#88c5e0",
                    confirmButtonText: "Delete",
                    showCancelButton: true
                }, function () {
                    that.loading = true;
                    item.delete(function () {
                        toastr.info('Comment has been deleleted.');
                        that.loading = false;
                        that.getList();
                    }, function () {
                        toastr.error('Error happened during comment deleting.');
                        that.loading = false;
                    });
                });
            },
        },
    });
}