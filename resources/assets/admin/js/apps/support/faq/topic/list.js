if (document.getElementById('admin-support-faq-topic-list')) {
    window.adminSupportFaqTopicList = new Vue({
        el: '#admin-support-faq-topic-list',
        data: {
            collection: new Collection(),
            loading: false,
            search: null,
            columns: [{key: 'id', title: 'ID'},
                    {key: 'question', title: 'Question'},
                    {key: 'answer', title: 'Answer'},
                    {key: 'created_at', title: 'Created At'}],
            sortKey: 'id',
            sortOrders: {},
            topic: new FaqTopic({types: []}),
            categories: new Collection()
        },
        mounted: function () {
            var that = this;
            //initialize sorting asc/desc
            this.columns.forEach(function (column) {
                that.sortOrders[column.key] = -1;
            });
            this.getCategories();
        },
        methods: {
            getCategories: function () {
                this.loading = true;
                faq_categories().adminAll(function(collection) {
                    adminSupportFaqTopicList.categories = collection;
                    adminSupportFaqTopicList.loading = false;
                    adminSupportFaqTopicList.getList(); 
                }, function() {
                    adminSupportFaqTopicList.categories = new Collection();
                    adminSupportFaqTopicList.loading = false;
                    adminSupportFaqTopicList.getList(); 
                });
            },
            getList: function() {
                this.closeModal();
                this.loading = true;
                var that = this;
                faq_topics().adminList(function(collection) {
                    adminSupportFaqTopicList.collection = collection;
                    adminSupportFaqTopicList.loading = false;
                }, function() {
                    adminSupportFaqTopicList.collection = new Collection();
                    adminSupportFaqTopicList.loading = false;
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
            deleteTopic: function(topic) {
                var that = this;
                swal({
                    title: "Delete topic?",
                    text: topic.get('question'),
                    type: 'error',
                    confirmButtonColor: "#88c5e0",
                    confirmButtonText: "Delete",
                    showCancelButton: true
                }, function() {
                    that.loading = true;
                    topic.delete(function() {
                        toastr.info('Topic has been deleleted.');
                        that.loading = false;
                        that.getList();
                    }, function () {
                        toastr.error('Error happened during topic deleting.');
                        that.loading = false;
                    });
                });
            },
            newTopic: function() {
                this.topic = new FaqTopic({types: []});
                $('#faq-topic-modal').modal('show');
            },
            editTopic: function(topic) {
                this.topic = topic;
                $('#faq-topic-modal').modal('show');
            },
            closeModal: function() {
                $('#faq-topic-modal').modal('hide');
            },
        },
    });
}