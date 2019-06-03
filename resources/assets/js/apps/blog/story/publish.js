if (document.getElementById('blog-story-publish')) {
    window.blogStoryPublish = new Vue({
        el: '#blog-story-publish',
        data: {
            button: null,
            errors: {},
            form: false,
            id: null
        },
        mounted: function () {
            this.id = this.$el.dataset.id;
            this.getStory();
        },
        methods: {
            getStory: function () {
                stories().get('/api/blog/story/' + this.id, function(story) {
                    blogStoryPublish.form = story;
                }, function () {
                    toastr.error('Error has occured during story obtaining', 'Story');
                });
            },
            publish: function (event) {
                if (this.form) {
                    this.$refs.editor.instance.focusManager.blur( true );
                    this.form.publish('/api/blog/story/' + this.form.get('slug') + '/publish', function() {
                        blogStoryPublish.errors = [];
                        swal({
                            title: 'Stories',
                            text: "Blog story was published successfully. Awaiting approval.",
                            type: 'success',
                            showCancelButton: false,
                            closeOnConfirm: true
                        }, function () {
                            //redirect to main page after success
                            window.location.replace('/');
                        });
                    },  function(error) {
                        if(error.response.status == 422) {
                            blogStoryPublish.errors = error.response.data;
                            toastr.error("Please correct the input data and try again.", 'Stories');
                        }
                    });
                }
            },
            headers: function() {
                var headers = window.axios.defaults.headers.common;
                return headers;
            },
            imageError: function (file, error, xhr) {
                if(!Array.isArray(error)) {
                    toastr.error(error, 'Image');
                }
                blogStoryPublish.errors = error;
                blogStoryPublish.dropzoneClear('storyImage');
            },
            imageSuccess: function (file, response) {
                blogStoryPublish.form.attributes.image = response.image;
                blogStoryPublish.dropzoneClear('storyImage');
                blogStoryPublish.errors = [];
            },
            dropzoneClear: function(id) {
                for(index in this.$children) {
                    var component = this.$children[index];
                    if(id == component.id) {
                        component.removeAllFiles();
                    }
                }
            }
        }
    });
}