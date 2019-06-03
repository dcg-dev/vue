if (document.getElementById('blog-story-view')) {
    window.blogStoryView = new Vue({
        el: '#blog-story-view',
        data: {
            errors: {},
            story: false,
            lastStories: new Stories(),
            story_id: null,
            current_user_id: null
        },
        computed: {
            isGuest: function() {
                return !window.currentUser;
            }
        },
        mounted: function () {
            this.story_id = this.$el.dataset.story_id;
            this.current_user_id = window.currentUser ? window.currentUser.get('username') : false;
            this.getStory();
        },
        methods: {
            getStory: function () {
                stories().get('/api/blog/story/' + this.story_id, function(story) {
                    blogStoryView.story = story;
                    blogStoryView.getLastStories();
                    blogStoryView.story.comments();
                }, function () {
                    toastr.error('Error has occured during story obtaining', 'Story');
                }, {
                    'relations': [
                        'creator'
                    ]
                });
            },
            getLastStories: function () {
                stories().all(function (list) {
                    blogStoryView.lastStories = list.data;
                }, function () {
                    toastr.error('Error has occured during the last stories obtaining', 'Stories');
                }, {
                    'page': 1,
                    'per_page': 6,
                    'order': [
                        'created_at|desc',
                    ],
                });
            },
            share: function(provider) {
                var storyUrl = location.origin + '/blog/story/' + this.story.get('slug');
                var username = window.currentUser ? window.currentUser.get('username') : false;
                switch (provider) {
                    case 'facebook':
                        social().facebook().share();
                        break;
                    case 'twitter':
                        social().twitter().share(
                                storyUrl, 
                                'Hi there! Check out this blog story "' + this.story.get('title') + '"',
                                'roqstar,' + (username ? ',' + username : '')
                                );
                        break;
                }
            },
            like: function(comment) {
               comment.like();
            }, 
            commentPage: function(page) {
                this.story.comments(null, null, {
                    'page': page
                });
            },
            likeStory: function () {
                if (this.isGuest) {
                    notify.guest("Please login to like it.");
                } else {
                    this.story.likeStory(this.story);
                }
            }
        }
    });
}