if (document.getElementById('admin-item-list')) {
    window.adminItemList = new Vue({
        el: '#admin-item-list',
        data: {
            collection: new Items(),
            loading: false,
            search: null,
            columns: [{key: 'id', title: 'ID'},
                    {key: 'name', title: 'Name'},
                    {key: 'slug', title: 'Slug'},
                    {key: 'price', title: 'Price'},
                    {key: 'status', title: 'Status'},
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
                items().adminList(function(collection){
                    adminItemList.collection = collection;
                    adminItemList.loading = false;
                }, function(){
                    adminItemList.loading = false;
                }, Object.assign({
                    'relations': [
                        'creator',
                    ],
                    'q': that.search,
                    'order': [that.sortKey + '|' + (that.sortOrders[that.sortKey] > 0 ? 'asc' : 'desc')]
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
            deleteItem: function(item) {
                var that = this;
                swal({
                    title: "Delete item?",
                    text: item.get('name'),
                    type: 'error',
                    confirmButtonColor: "#88c5e0",
                    confirmButtonText: "Delete",
                    showCancelButton: true
                }, function() {
                    that.loading = true;
                    item.delete(function() {
                        toastr.info('Item has been deleleted.');
                        that.loading = false;
                        that.getList();
                    }, function () {
                        toastr.error('Error happened during item deleting.');
                        that.loading = false;
                    });
                });
            },
        },
    });
}