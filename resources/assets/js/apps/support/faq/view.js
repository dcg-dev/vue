if (document.getElementById('support-faq-view')) {
    window.supportFaqView = new Vue({
        el: '#support-faq-view',
        data: {
            topics: new Collection(),
            categories: [],
            search: null,
            countAccount: 0,
            countFeatures: 0,
            countServices: 0,
            countPayment: 0,
            filter: null
        },
        computed: {
            currentUser: function() {
                return currentUser;
            }
        },
        mounted: function () {
            this.getTopics();
        },
        methods: {
            getTopics: function (search) {
                var that = this;
                that.search = search;
                that.loading = true;
                faq_topics().all(function (list) {
                    that.topics = list;
                    that.categories = _.uniq(_.map(list.data, 'attributes.category.attributes.name'));
                    that.countTypes(list.data);
                    that.loading = false;
                }, function () {
                    that.topics = new Collection();
                    toastr.error('Error has occured during FAQ Topics obtaining', 'FAQ Topics');
                    that.loading = false;
                }, {
                    'q': that.search,
                    'filter': that.filter,
                    'relations': [
                        'category'
                    ]
                });
            },
            countTypes: function (list) {
                var array = _.flatten(_.map(list, 'attributes.types'));
                this.countAccount = _.filter(array, function(value) {
                                        return value == 'account';
                                    }).length;
                this.countFeatures = _.filter(array, function(value) {
                                        return value == 'features';
                                    }).length;
                this.countServices = _.filter(array, function(value) {
                                        return value == 'services';
                                    }).length;
                this.countPayment = _.filter(array, function(value) {
                                        return value == 'payment';
                                    }).length;
                                    
            },
            setFilter: function (type, event) {
                if (!this.loading) {
                    $(event.currentTarget).parent().find('.block-content-mini').removeClass('bg-info');
                    if (this.filter != type) {
                        $(event.currentTarget).find('.block-content-mini').addClass('bg-info');
                        this.filter = type;
                    } else {
                        this.filter = null;
                    }
                    this.getTopics(this.search);
                } else {
                    toastr.error('Wait a few moments, questions are loading', 'FAQ');
                }
            }
        },
    });
}