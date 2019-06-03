if (document.getElementById('categories-mobile')) {
    window.categoriesNavMobile = new Vue({
        el: '#categories-mobile',
        data: {
            list: new Categories()
        },
        mounted: function () {
            this.getList(); //todo
        },
        methods: {
            getList: function(callback, errorCallback) {
                categories().all(function(list) {
                    categoriesNavMobile.list = list;
                }, function(){
                    categoriesNavMobile.list = new Categories();
                }, {
                    'relations': [
                        'childs'
                    ]
                });
            },
        },
    });
}