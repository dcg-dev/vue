if (document.getElementById('blog-story-list')) {
    window.blogStoryList = new Vue({
        el: '#blog-story-list',
        data: {
            stories: new Stories(),
            loading: false,
            pagination: {
                total: 0,
                per_page: 6,
                from: 1,
                to: 0,
                current_page: 1
            },
            search: null,
            publisher: null,
            topStories: new Stories(),
        },
        mounted: function () {
            this.getList(this.pagination.current_page, this.pagination.per_page, this.search);
            this.getRandomPublisher();
            this.getTopStories();
        },
        methods: {
            getList: function (page, per_page, search) {
                var that = this;
                if (that.loading) {
                    toastr.error('Sorry, the list is currently loading.', 'Stories');
                    return;
                }
                stories().all(function (list) {
                    that.stories = list;
                    that.pagination = list;
                    that.loading = false;
                }, function () {
                    that.stories = new Collection(),
                    toastr.error('Error has occured during the last stories obtaining', 'Stories');
                    that.loading = false;
                }, {
                    'page': page,
                    'per_page': per_page,
                    'q': search,
                    'order': [
                        'created_at|desc',
                    ],
                });
            },
            page: function (page) {
                this.getList(page, this.pagination.per_page, this.search);
            },
            getRandomPublisher: function () {
                axios.get('/blog/story/publisher').then((response) => {
                    if (response.data) {
                        this.publisher = new User(response.data);
                    }
                }, (error) => {
                    toastr.error('Error has occured during publisher obtaining', 'Stories');
                });
            },
            share: function(provider, story) {
                var storyUrl = location.origin + '/blog/story/' + story.get('slug');
                var username = window.currentUser ? window.currentUser.get('username') : false;
                switch (provider) {
                    case 'facebook':
                        $('meta[property="og:url"]').replaceWith( '<meta property="og:url" content="' + storyUrl + '">' );
                        $('meta[property="og:type"]').replaceWith( '<meta property="og:type" content="website">' );
                        $('meta[property="og:title"]').replaceWith('<meta property="og:title" content="' + story.get('title') + '">');
                        $('meta[property="og:image"]').replaceWith( '<meta property="og:image" content="' + location.origin + story.get('image') + '">' );
                        social().facebook().share(storyUrl);
                        break;
                    case 'twitter':
                        social().twitter().share(
                                storyUrl, 
                                'Hi there! Check out this blog story "' + story.get('title') + '"',
                                'roqstar' + (username ? ',' + username : '')
                                );
                        break;
                }
            },
            getTopStories: function () {
                var that = this;
                if (that.loading) {
                    toastr.error('Sorry, the list is currently loading.', 'Stories');
                    return;
                }
                stories().all(function (list) {
                    that.topStories = list;
                    that.loading = false;
                }, function () {
                    that.topStories = new Collection(),
                    toastr.error('Error has occured during the most popular stories obtaining', 'Stories');
                    that.loading = false;
                }, {
                    'page': 1,
                    'per_page': 5,
                    'order': [
                        'count_likes|desc',
                        'created_at|desc',
                    ],
                });
            },
        },
        filters: {
            truncate: function (text) {
                return new StringHelper(text).truncate(200);
            }
        }
    });
}