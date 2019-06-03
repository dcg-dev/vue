if (document.getElementById('item-featured')) {
    window.itemFeatured = new Vue({
        el: '#item-featured',
        data: {
            items: new Items(),
        },
        mounted: function () {
            this.get();
        },
        methods: {
            get: function () {
                this.loading = true;
                items().featured(function (list) {
                    itemFeatured.items = list;
                }, function () {
                    itemFeatured.items = new Items();
                },queryString.parse(location.search));
            },
            paginate: function () {
                this.get();
            }
        },
    });
}