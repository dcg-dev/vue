if (document.getElementById('collection-view')) {
    window.collectionView = new Vue({
        el: '#collection-view',
        data: {
            id: null,
            collection: false,
            filters: {
                q: '',
                order: '',
            },
        },
        computed: {
            currentUser: function () {
                return currentUser;
            }
        },
        created: function () {
            this.filters = Object.assign(this.filters, queryString.parse(location.search));
        },
        mounted: function () {
            this.id = this.$el.dataset.id;
            this.get();
        },
        methods: {
            get: function () {
                itemCollections().get('/api/collection/' + this.id, function (collection) {
                    collectionView.collection = collection;
                    collectionView.refresh();
                }, null, {
                    'relations': [
                        'creator',
                    ]
                });
            },
            share: function (provider) {
                switch (provider) {
                    case 'facebook':
                        social().facebook().share();
                        break;
                    case 'google':
                        social().google().share();
                        break;
                    case 'linkedin':
                        social().linkedin().share();
                        break;
                    case 'twitter':
                        social().twitter().share(
                            false,
                            window.currentUser && window.currentUser.get('id') == this.collection.get('creator').get('id') ?
                                'Hi there! Check out my track collection "' + this.collection.get('name') + '" at ' + location.host :
                                'Hi there! Check out this awesome track collection"' + this.collection.get('name') + '" at ' + location.host,
                            'roqstar,' + window.currentUser.get('username')
                        );
                        break;
                }
            },
            find: function () {
                var query = Object.assign(queryString.parse(location.search), this.filters);
                history.pushState(null, null, location.origin + location.pathname + '?' + queryString.stringify(query, {arrayFormat: 'index'}));
                this.refresh();
            },
            refresh: function () {
                this.collection.items(null, null, Object.assign(queryString.parse(location.search), {
                    'relations': [
                        'creator',
                    ]
                }));
            },
            follow: function () {
                if (this.currentUser && this.collection) {
                    this.collection.follow();
                } else {
                    notify.guest("Please login to follow/unfollow.");
                }
            },
            save: function (name) {
                var self = this;
                var promise = axios.post('/api/collection/' + this.collection.get('slug') + '/save', {name: name});
                promise.then(function (response) {
                    self.collection.setAttributes(response.data);
                });
            },
            remove: function () {
                if (this.currentUser.get('id') != this.collection.get('creator_id')) {
                    return false;
                }
                var vm = this;
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this collection!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                }, function () {
                    vm.collection.delete(function (value) {
                        location.href = '/user/' + vm.currentUser.get('username') + '/collections';
                    });
                });
            },
        },
    });
}