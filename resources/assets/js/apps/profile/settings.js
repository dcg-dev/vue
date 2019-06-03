if (document.getElementById('profile-settings')) {
    window.profileSettings = new Vue({
        el: '#profile-settings',
        data: {
            button: null,
            errors: [],
            form: {},
            tab: null
        },
        created: function() {
            if(!currentUser) {
                location.reload();
            }
        },
        computed: {
            currentUser: function () {
                return currentUser;
            }
        },
        mounted: function () {
            this.tab = 'general';
            this.getCurrentProfile();
            $('#profile-settings').removeClass('hide');
        },
        methods: {
            getCurrentProfile: function() {
                this.errors = [];
                axios.get('/api/profile/current').then((response) => {
                    //initialize form for profile
                    this.form = response.data;
                    if(!this.currentUser.canUsePro()) {
                        this.form.notification_sale = false;
                        this.form.notification_inbox = false;
                        this.form.notification_comments = false;
                        this.form.notification_reviews = false;
                    }
                }, (error) => {
                    this.errors = error.response.data;
                    toastr.error("Profile Data couldn't be retrieve.", 'Settings');
                });
            },
            updateSettings: function(event) {
                this.errors = [];
                var data = this.form;
                data.tab = this.tab;
                axios.post('/api/profile/updateSettings', data).then((response) => {
                    if (response.data) {
                        notify.success("Profile Settings has been updated!", 'Settings');
                        this.form = response.data;
                    }
                }, (error) => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data;
                        toastr.error("Please correct the input data and try again.", 'Settings');
                    }
                });
            },
        },
    });
}