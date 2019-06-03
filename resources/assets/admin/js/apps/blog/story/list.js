if (document.getElementById('admin-blog-story-list')) {
    window.adminBlogStoryList = new Vue({
        el: '#admin-blog-story-list',
        data: {
            list: {},
            loading: {
                list: false
            },
            errors: {
                modal: [],
            },
            pagination: {
                total: 0,
                per_page: 16,
                from: 1,
                to: 0,
                current_page: 1
            },
            offset: 16,
        },
        mounted: function () {
            this.getList(this.pagination.current_page, this.pagination.per_page);
        },
        methods: {
            getList: function (page, per_page) {
                if(this.loading.list) {
                    toastr.error('Sorry, the list is currently loading.', 'Stories');
                    return;
                }
                this.loading.list = true;
                axios.get('/control/api/story/list?page=' + page + '&per_page=' + per_page).then((response) => {
                    if (response.data) {
                        this.list = response.data.data;
                        this.pagination = response.data;
                        this.loading.list = false;
                    }
                }, (error) => {
                    toastr.error('Error has occured during stories obtaining', 'Stories');
                    this.loading.list = false;
                });
            },
            toggleApprove: function (slug, status, event) {
                var currentTD = $(event.currentTarget).parent();
                this.toggleDisableButtons(currentTD);
                axios.post('/control/api/story/' + slug + '/approving', {approved: status})
                    .then((response) => {
                        if (response.data) {
                            //update current story in stories
                            var that = this;
                            _.each(that.list, function(story, key) {
                                if (story.id == response.data.id) {
                                    Vue.set(that.list[key], 'approved', response.data.approved);
                                    return;
                                }
                            });
                        }
                        toastr.info('Story approving status has been changed successfully!', 'Stories');
                        this.toggleDisableButtons(currentTD);
                    }, (error) => {
                        toastr.error('Error has occured during story approving.', 'Stories');
                        this.toggleDisableButtons(currentTD);
                    });
            },
            toggleDisableButtons: function (currentTD) {
                currentTD.find('button').prop('disabled', function(i, v) { return !v; });
            },
            editStory: function (slug) {
                location.href='/control/blog/story/' + slug + '/edit';
            },
            deleteStory: function (slug, event) {
                var currentTD = $(event.currentTarget).parent();
                this.toggleDisableButtons(currentTD);
                axios.delete('/control/api/story/' + slug).then((response) => {
                    if (response.data.status) {
                        toastr.info('Story has been deleted successfully!', 'Stories');
                        this.toggleDisableButtons(currentTD);
                        var that = this;
                        _.each(that.list, function(story, key) {
                            if (story.slug == slug) {
                                Vue.delete(that.list, key);
                                return;
                            }
                        });
                    } else {
                        this.toggleDisableButtons(currentTD);
                        toastr.error('Error has occured during story deleting. Try again.', 'Stories');
                    }
                }, (error) => {
                    toastr.error('Error has occured during story deleting. Try again.', 'Stories');
                    this.toggleDisableButtons(currentTD);
                });
            }
        },
        filters: {
            moment: function (date) {
                return moment.unix(date).format('HH:mm:ss DD-MM-YYYY');
            }
        }
    });
}