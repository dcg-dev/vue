if (document.getElementById('admin-user-edit')) {
    window.adminUserEdit = new Vue({
        el: '#admin-user-edit',
        data: {
            form: {
                attributes: {
                    skillIds: [],
                    role: [],
                    gender: []
                }
            },
            errors: [],
            button: null,
            createMode: false,
            allowedSkills: [],
            loading: false
        },
        mounted: function () {
            this.username = this.$el.dataset.username;
            this.getUser();
            this.getAllowedSkills();
        },
        methods: {
            getUser: function () {
                users().get('/control/api/user/' + this.username, function (user) {
                    adminUserEdit.form = user;
                });
            },
            submit: function (isCreateMode, event) {
                //if username was created
                if (!isCreateMode) {
                    var self = this.form;
                    this.errors = [];
                    if (!this.button) {
                        this.button = Ladda.create(event.target);
                    }
                    this.button.start();
                    axios.post('/control/api/user/' + this.username + '/update', this.form.attributes).then((response) => {
                        if (response.data) {
                            toastr.info("User has been successfully updated!", 'User');
                            if (self.attributes.username != response.data.username) {
                                location.href = "/control/user/" + response.data.attributes.username + "/edit";
                            }
                        }
                        adminUserEdit.button.stop();
                    }, function (error) {
                        if (error.response.status == 422) {
                            adminUserEdit.errors = error.response.data;
                            toastr.error("Please correct the input data and try again.", 'User');
                        }
                        adminUserEdit.button.stop();
                    });
                }
            },
            getAllowedSkills: function () {
                this.loading = true;
                axios.get('/api/skill/list').then((response) => {
                    //initialize skills
                    this.allowedSkills = response.data;
                    this.loading = false;
                }, (error) => {
                    toastr.error("Skills Data couldn't be retrieve.", 'User');
                    this.loading = false;
                });
            },
            headers: function () {
                var headers = window.axios.defaults.headers.common;
                return headers;
            },
            avatarError: function (file, error, xhr) {
                if (!Array.isArray(error)) {
                    toastr.error(error, 'Avatar');
                }
                this.errors = error;
                this.dropzoneClear('userAvatar');
            },
            avatarSuccess: function (file, response) {
                this.form = new User(response);
                this.dropzoneClear('userAvatar');
                this.errors = [];
            },
            dropzoneClear: function (id) {
                for (index in this.$children) {
                    var component = this.$children[index];
                    if (id == component.id) {
                        component.removeAllFiles();
                    }
                }
            },
            ban: function () {
                let action = this.form.attributes.banned_at ? "unban" : "ban";
                swal({
                    title: 'Are you sure?',
                    text: `Do you really want to ${action} this user?`,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: `Yes, ${action} this user!`,
                    cancelButtonText: 'No, cancel!',
                    buttonsStyling: false,
                    reverseButtons: true
                }, (result) => {
                    if (result) {
                        axios.post('/control/api/user/' + this.username + '/ban').then((response) => {
                            if (response.data) {
                                swal({
                                    type: 'success',
                                    title: `User has been successfully ${action}ned!`,
                                    showConfirmButton: false
                                });
                                console.log(this);
                                this.form.attributes.banned_at = response.data.banned_at;
                            }
                        });
                    }
                })
            }
        },
    });
}