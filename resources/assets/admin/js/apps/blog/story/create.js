if (document.getElementById('admin-blog-story-create')) {
    window.adminBlogStoryCreate = new Vue({
        el: '#admin-blog-story-create',
        data: {
            form: {
                title: null,
                sub_title: null,
                text: null,
                approved: false
            },
            errors: {},
            button: null
        },
        methods: {
            submit: function (isUpdate, event) {
                //if slug was not created
                this.$refs.editor.instance.focusManager.blur( true );
                if (!isUpdate) {
                    this.errors = [];
                    if(!this.button) {
                        this.button = Ladda.create(event.target);
                    }
                    this.button.start();
                    axios.post('/control/api/story/create', this.form).then((response) => {
                        if (response.data) {
                            toastr.info("Story has been successfully created!", 'Stories');
                        }
                        this.button.stop();
                        //go to edit this story
                        location.href='/control/blog/story/' + response.data.slug + '/edit';
                    }, (error) => {
                        if(error.response.status == 422) {
                            this.errors = error.response.data;
                            toastr.error("Please correct the input data and try again.", 'Stories');
                        }
                        this.button.stop();
                    });
                } else {
                    toastr.error("Slug was already created, refresh page.", 'Stories');
                }
            }
        },
    });
}