if (document.getElementById('admin-user-list')) {
    window.adminUserList = new Vue({
        el: '#admin-user-list',
        data: {
            collection: new Users(),
            loading: false,
            search: null,
            columns: [{key: 'id', title: 'ID'},
                    {key: 'username', title: 'Username'},
                    {key: 'role', title: 'Role'},
                    {key: 'email', title: 'Email'},
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
                users().all(function(collection){
                    that.collection = collection;
                    that.loading = false;
                }, function() {
                    that.loading = false;
                }, {
                    'q': that.search,
                    'order': [that.sortKey + '|' + (that.sortOrders[that.sortKey] > 0 ? 'asc' : 'desc')],
                });
            },
            page: function() {
                this.getList();
            },
            deleteUserApprove: function(user) {
                var that = this;
                swal({
                    title: "Delete user?",
                    text: user.getFullname() + ' - ' + user.get('email'),
                    type: 'error',
                    confirmButtonColor: "#88c5e0",
                    confirmButtonText: "Delete",
                    showCancelButton: true,
                }, function() {
                    that.loading = true;
                    user.delete(function() {
                        toastr.info('User has been deleleted.');
                        that.loading = false;
                        that.getList();
                    }, function () {
                        toastr.error('Error happened during user deleting.');
                        that.loading = false;
                    });
                });
            },
            sortBy: function(key) {
                this.sortKey = key;
                this.sortOrders[key] *= -1;
                this.getList();
            }
        },
    });
}