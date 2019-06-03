if (document.getElementById('profile-edit')) {
    window.profileEdit = new Vue({
        el: '#profile-edit',
        data: {
            button: null,
            errors: [],
            form: {
                skills: []
            },
            allowedSkills: []
        },
        mounted: function () {
            this.getCurrentProfile();
            this.getAllowedSkills();
        },
        computed: {
            currentUser: function () {
                return currentUser;
            }
        },
        methods: {
            getCurrentProfile: function () {
                this.errors = [];
                axios.get('/api/profile/current').then((response) => {
                    //initialize form for profile
                    profileEdit.form = response.data;
                    Vue.set(profileEdit.form, 'skills', profileEdit.form.skillIds);
                }, (error) => {
                    this.errors = error.response.data;
                    toastr.error("Profile Data couldn't be retrieve.", 'Profiles');
                });
            },
            getAllowedSkills: function () {
                axios.get('/api/skill/list').then((response) => {
                    //initialize form for profile
                    this.allowedSkills = response.data;
                }, (error) => {
                    toastr.error("Skills Data couldn't be retrieve.", 'Profiles');
                });
            },
            saveChanges: function (event) {
                this.errors = [];
                axios.post('/api/profile/update', this.form).then((response) => {
                    if (response.data) {
                        notify.success("Profile has been updated!", 'Profiles');
                        // toastr.info("Profile has been updated!", 'Profiles');
                        profileEdit.form = response.data;
                        Vue.set(profileEdit.form, 'skills', profileEdit.form.skillIds);
                    }
                }, (error) => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data;
                        toastr.error("Please correct the input data and try again.", 'Profiles');
                    }
                });
            },
            previewThumbnail: function (event) {
                var input = event.target;
                //if a file was uploaded
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    var that = this;
                    reader.onload = function(e) {
                        that.form.avatar = e.target.result;
                    }
                    //fill image by base64 data
                    reader.readAsDataURL(input.files[0]);
                }
            }
        },
    });
}