if (document.getElementById('categories')) {
    window.categoriesNav = new Vue({
        el: '#categories',
        data: {
            list: new Categories(),
            parent: null 
        },
        mounted: function () {
            this.getList();
        },
        computed: {
            location: function () {
                return location;
            }
        },
        methods: {
            getList: function (callback, errorCallback) {
                categories().all(function (list) {
                    categoriesNav.list = list;
                }, function () {
                    categoriesNav.list = new Categories();
                }, {
                    'relations': [
                        'childs'
                    ]
                });
            },
        },
    });
}