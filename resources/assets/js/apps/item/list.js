if (document.getElementById('item-list')) {
    window.itemList = new Vue({
        el: '#item-list',
        data: {
            items: new Collection(),
            loading: false,
        },
        mounted: function () {
            this.get();
        },
        methods: {
            get: function() {
                this.loading = true;
                items().my(function(list) {
                    itemList.items = list;
                    itemList.loading = false;
                },function(){
                    itemList.items = new Collection(),
                    itemList.loading = false;
                }, queryString.parse(location.search));
            },
            paginate: function() {
                this.get();
            },
            remove: function (item) {
                var that = this;

                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this item!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                }, function () {
                    axios.post('/api/item/'+ item.get('id') + '/delete', {}).then((response) => {
                        that.get();
                        toastr.success("Item successfully deleted!", 'Items');
                    }, (error) => {
                    });
                });
            }
        },
    });
}