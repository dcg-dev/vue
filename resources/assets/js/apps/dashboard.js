if (document.getElementById('dashboard')) {
    window.dashboard = new Vue({
        el: '#dashboard',
        data: {
            itemsPagination: 0,
            popularPagination: 0,
            sellersPagination: 0,
            featuredPagination: 0,
            storiesPagination: 0,
            arrivals: new Items(),
            featured: new Items(),
            populars: new Items(),
            sellers: new Users(),
            stories: new Stories(),
        },
        mounted: function () {
            this.itemsPagination = this.$el.dataset.items_pagination;
            this.popularPagination = this.$el.dataset.popular_pagination;
            this.sellersPagination = this.$el.dataset.sellers_pagination;
            this.featuredPagination = this.$el.dataset.featured_pagination;
            this.storiesPagination = this.$el.dataset.stories_pagination;
            this.getArrivals();
            this.getPopular();
            this.getFeatured();
            this.getSellers();
            this.getStories();
        },
        methods: {
            getArrivals: function() {
                var that = this;
                items().all(function(list) {
                    that.arrivals = list;
                },function(){
                    that.arrivals = new Items();
                }, {
                    'order': [
                        'approved_at|desc',
                        'name|asc',   
                    ],
                    'per_page': (that.itemsPagination != 0) ? that.itemsPagination : 8
                });
            },
            getPopular: function() {
                var that = this;
                items().all(function(list) {
                    that.populars = list;
                },function(){
                    that.populars = new Items();
                }, {
                    'order': [
                        'count_sales|desc',
                        'rating|desc',
                        'count_followers|desc',
                        'count_items|desc',
                        'created_at|asc',
                    ],
                    'per_page': (that.popularPagination != 0) ? that.popularPagination : 8
                });
            },
            getSellers: function() {
                var that = this;
                users().all(function(list) {
                    that.sellers = list;
                },function(){
                    that.sellers = new Users();
                }, {
                    'order': [
                        'count_sales|desc',
                        'rating|desc',
                        'count_followers|desc',
                        'count_items|desc',
                        'created_at|asc',
                    ],
                    'per_page': (that.sellersPagination != 0) ? that.sellersPagination : 6
                });
            },
            getStories: function() {
                var that = this;
                stories().all(function(list) {
                    that.stories = list;
                },function(){
                    that.stories = new Stories();
                }, {
                    'order': [
                        'created_at|desc',
                    ],
                    'per_page': (that.storiesPagination != 0) ? that.storiesPagination : 3
                });
            },
            getFeatured: function() {
                var that = this;
                items().featured(function(list) {
                    that.featured = list;
                },function(){
                    that.featured = new Items();
                }, {
                    'per_page': (that.featuredPagination != 0) ? that.featuredPagination : 6
                });
            },
        },
    });
}