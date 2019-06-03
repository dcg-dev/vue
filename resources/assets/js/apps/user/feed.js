if (document.getElementById('user-feed')) {
    window.userFeed = new Vue({
        el: '#user-feed',
        data: {
            currentUser: new User(),
            collection: new Items(),
            categories: new Categories(),
            filters: {},
        },
        mounted: function () {
            this.currentUser = currentUser;
            this.getCategories();
            this.filters = queryString.parse(location.search);
        },
        methods: {
            get: function () {
                this.currentUser.feed(function (list) {
                    userFeed.collection = list;
                }, function () {
                    userFeed.collection = new Items();
                }, Object.assign(queryString.parse(location.search), {
                    'relations': [
                        'creator'
                    ],
                }));
            },
            following: function () {
                this.currentUser.following(null, null, {
                    'per_page': 4
                });
            },
            getCategories: function () {
                categories().all(function (list) {
                    userFeed.categories = list;
                    if (!userFeed.categories.isEmpty()) {
                        var count = userFeed.categories.count();
                        var step = 1;
                        userFeed.categories.getData().forEach(function (category) {
                            userFeed.currentUser.feedCount(function (count) {
                                category.set('count', count);
                            }, null, {
                                'category': category.get('id'),
                            });
                            if (step == count) {
                                setTimeout(function () {
                                    userFeed.refresh();
                                }, 300);
                            } else {
                                step++;
                            }
                        });
                    } else {
                        userFeed.categories = list;
                        userFeed.refresh();
                    }
                }, function () {
                    userFeed.categories = new Categories();
                }, {
                    'relations': []
                });
            },
            filter: function (key, value) {
                var query = queryString.parse(location.search, {arrayFormat: 'index'});
                query[key] = value;
                this.filters[key] = value;
                delete query.page;
                history.pushState(null, null, location.origin + location.pathname + '?' + queryString.stringify(query, {arrayFormat: 'index'}));
                this.refresh();
            },
            refresh: function () {
                this.get();
                this.following();
            },
        },
    });
}