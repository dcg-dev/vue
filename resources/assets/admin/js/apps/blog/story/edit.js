if (document.getElementById('admin-blog-story-edit')) {
    window.adminBlogStoryEdit = new Vue({
        el: '#admin-blog-story-edit',
        data: {
            form: {},
            errors: {},
            button: null,
            slug: null
        },
        mounted: function () {
            this.slug = this.$el.dataset.slug;
            this.getStory();
        },
        methods: {
            getStory: function () {
                this.errors = [];
                axios.get('/control/api/story/' + this.slug).then((response) => {
                    //initialize story
                    this.form = response.data;
                }, (error) => {
                    this.errors = error.response.data;
                    toastr.error("Story Data couldn't be retrieve.", 'Stories');
                });
            },
            submit: function (isUpdate, event) {
                //if slug was created
                if (isUpdate) {
                    this.$refs.editor.instance.focusManager.blur( true );
                    this.errors = [];
                    if(!this.button) {
                        this.button = Ladda.create(event.target);
                    }
                    this.button.start();
                    axios.post('/control/api/story/'  + this.slug + '/update', this.form).then((response) => {
                        if (response.data) {
                            toastr.info("Story has been successfully updated!", 'Stories');
                        }
                        this.form = response.data;
                        this.slug = response.data.slug;
                        this.button.stop();
                    }, (error) => {
                        if(error.response.status == 422) {
                            this.errors = error.response.data;
                            toastr.error("Please correct the input data and try again.", 'Stories');
                        }
                        this.button.stop();
                    });
                } else {
                    toastr.error("Slug wasn't created, refresh page.", 'Stories');
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
                this.errors = error;
                this.dropzoneClear('storyImage');
            },
            imageSuccess: function (file, response) {
                this.form = response;
                this.dropzoneClear('storyImage');
                this.errors = [];
            },
            dropzoneClear: function(id) {
                for(index in this.$children) {
                    var component = this.$children[index];
                    if(id == component.id) {
                        component.removeAllFiles();
                    }
                }
            }
        },
    });
}