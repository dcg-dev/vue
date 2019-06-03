if (document.getElementById('admin-support-faq-category-list')) {
    window.adminSupportFaqCategoryList = new Vue({
        el: '#admin-support-faq-category-list',
        data: {
            collection: new Collection(),
            loading: false,
            search: null,
            columns: [{key: 'id', title: 'ID'},
                    {key: 'name', title: 'Name'},
                    {key: 'created_at', title: 'Created At'}],
            sortKey: 'id',
            sortOrders: {},
            category: new FaqCategory()
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
                this.closeModal();
                this.loading = true;
                var that = this;
                faq_categories().adminList(function(collection) {
                    adminSupportFaqCategoryList.collection = collection;
                    adminSupportFaqCategoryList.loading = false;
                }, function() {
                    adminSupportFaqCategoryList.collection = new Collection();
                    adminSupportFaqCategoryList.loading = false;
                }, Object.assign({
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
            deleteCategory: function(category) {
                var that = this;
                swal({
                    title: "Delete category?",
                    text: category.get('name'),
                    type: 'error',
                    confirmButtonColor: "#88c5e0",
                    confirmButtonText: "Delete",
                    showCancelButton: true
                }, function() {
                    that.loading = true;
                    category.delete(function() {
                        toastr.info('Category has been deleleted.');
                        that.loading = false;
                        that.getList();
                    }, function () {
                        toastr.error('Error happened during category deleting.');
                        that.loading = false;
                    });
                });
            },
            newCategory: function() {
                this.category = new FaqCategory();
                $('#faq-category-modal').modal('show');
            },
            editCategory: function(category) {
                this.category = category;
                $('#faq-category-modal').modal('show');
            },
            closeModal: function() {
                $('#faq-category-modal').modal('hide');
            },
        },
    });
}