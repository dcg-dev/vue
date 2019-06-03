if (document.getElementById('admin-user-create')) {
    window.adminUserCreate = new Vue({
        el: '#admin-user-create',
        data: {
            form: {
                attributes: {
                    role: [],
                    gender: []
                }
            },
            errors: [],
            button: null,
            createMode: true,
            allowedSkills: [],
            loading: false
        },
        methods: {
            submit: function (isCreateMode, event) {
                //if username was not created
                if (isCreateMode) {
                    this.errors = [];
                    if(!this.button) {
                        this.button = Ladda.create(event.target);
                    }
                    this.button.start();
                    axios.post('/control/api/user/create', this.form.attributes).then((response) => {
                        if (response.data) {
                            //go to edit this user
                            toastr.info("User has been successfully created!", 'User');
                            location.href='/control/user/' + response.data.username + '/edit';
                        }
                        adminUserCreate.button.stop();
                    }, function(error) {
                        if(error.response.status == 422) {
                            adminUserCreate.errors = error.response.data;
                            toastr.error("Please correct the input data and try again.", 'User');
                        }
                        adminUserCreate.button.stop();
                    });
                } else {
                    toastr.error("Username was not created, refresh the page.", 'User');
                }
            },
        },
    });
}