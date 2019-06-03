if (document.getElementById('top-sellers')) {
    window.topSellers = new Vue({
        el: '#top-sellers',
        data: {
            sellers: new Users(),
        },
        mounted: function () {
            this.refresh();
        },
        methods: {
            get: function() {
                users().all(function(list){
                     topSellers.sellers = list;
                }, function(){
                    topSellers.sellers = new ItemCollections();
                }, Object.assign(queryString.parse(location.search, {arrayFormat: 'index'}), {
                    'per_page': 'pagination.user.topsellers',
                    'order': [
                        'count_sales|desc',
                        'rating|desc',
                        'count_followers|desc',
                        'count_items|desc',
                        'created_at|asc',
                    ],
                }));
            },
            refresh: function() {
                this.get();
            },
        },
    });
}