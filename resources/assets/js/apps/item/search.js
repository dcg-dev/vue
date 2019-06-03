if (document.getElementById('item-search')) {
    window.itemSearch = new Vue({
        el: '#item-search',
        data: {
            category: false,
            currentCategory: new Category(),
            items: new Items(),
            filters: {},
            categories: new Categories(),
            formats: new Formats(),
            tags: new Tags,
        },
        mounted: function () {
            this.category = this.$el.dataset.category;
            this.loadFilters();
            this.getCategories();
            this.getFormats();
            this.getTags();
            this.get();
            this.init();
        },
        methods: {
            init: function () {
                items().max('price', function (price) {
                    var from = 0, to = price;
                    if (itemSearch.filters.price) {
                        var range = new StringHelper(itemSearch.filters.price).explode('|');
                        from = range[0];
                        to = range[1];
                    }
                    $("#price-slider").ionRangeSlider({
                        type: "double",
                        min: 0,
                        max: price,
                        from: from,
                        to: to,
                        prefix: '$',
                        input_values_separator: '|',
                        grid: true,
                        onFinish: function (value) {
                            if (value.from == 0 && value.to == price) {
                                delete itemSearch.filters.price;
                            } else {
                                itemSearch.filters.price = value.from + '|' + value.to;
                            }
                            itemSearch.refresh();
                        },
                    });
                });
            },
            loadFilters: function () {
                this.clearFilters();
                this.filters = queryString.parse(location.search, {arrayFormat: 'index'});
            },
            clearFilters: function () {
                this.filters = {};
            },
            getFilters: function () {
                for (key in this.filters) {
                    var value = this.filters[key];
                    if (!value) {
                        delete this.filters[key];
                    }
                }
                return this.filters;
            },
            get: function () {
                var params = queryString.parse(location.search, {arrayFormat: 'index'});
                if (this.category && !params.categories) {
                    delete params.categories;
                    params.categories = [this.category];
                }
                this.loading = true;
                items().all(function (list) {
                    itemSearch.items = list;
                }, function () {
                    itemSearch.items = new Items();
                }, Object.assign({
                    'order': [
                        'latest'
                    ],
                    'relations': [
                        'creator'
                    ],
                }, params));
            },
            refresh: function () {
                var old = queryString.parse(location.search, {arrayFormat: 'index'});
                var params = Object.assign(this.getFilters());
                if (old.order) {
                    params.order = old.order;
                }
                if (old.page) {
                    params.page = old.page;
                }
                if (old.per_page) {
                    params.per_page = old.per_page;
                } else {
                    params.per_page = 18;
                }
                history.pushState(null, null, location.origin + location.pathname + '?' + queryString.stringify(params, {arrayFormat: 'index'}));
                this.get();
            },
            getCategories: function () {
                var params = {
                    'relations': [
                        'childs'
                    ],
                };
                //'overall': true
                if (this.category) {
                    params.ids = [this.category];
                }
                categories().all(function (list) {
                    if (itemSearch.category) {
                        itemSearch.currentCategory = list.find(itemSearch.category);
                        itemSearch.categories = itemSearch.currentCategory.get('childs');
                    } else {
                        itemSearch.categories = list;
                    }
                }, function () {
                    itemSearch.categories = new Categories();
                }, params);
            },
            getFormats: function () {
                formats().all(function (list) {
                    itemSearch.formats = list;
                });
            },
            getTags: function () {
                tags().all(function (list) {
                    itemSearch.tags = list;
                });
            },
            hasCategory: function (id) {
                if (!this.filters.categories) {
                    this.filters.categories = [];
                }
                return (this.filters.categories.indexOf(id) != -1) ? true : false;
            },
            toggleCategory: function (id, event) {
                if (event) {
                    if (event.target.checked) {
                        if (!this.hasCategory(id)) {
                            this.filters.categories.push(id);
                        }
                    } else {
                        this.filters.categories.splice(this.filters.categories.indexOf(id), 1);
                    }
                } else {
                    if (!this.hasCategory(id)) {
                        this.filters.categories.push(id);
                    } else {
                        this.filters.categories.splice(this.filters.categories.indexOf(id), 1);
                    }
                }
                this.refresh();
            },
            getOrderTitle: function () {
                if ('undefined' !== typeof this.filters.order && 'undefined' !== typeof this.filters.order[0]) {
                    switch (this.filters.order[0]) {
                        case 'created_at|desc':
                            return 'Latest Items';
                        case 'popular':
                            return 'Popular Items';
                        default:
                            return '';
                    }
                } else {
                    if(this.filters.tags && this.filters.tags[0]) {

                    }
                    return '';
                }
            }
        },
    });
}