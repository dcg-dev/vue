if (document.getElementById('user-view')) {
    window.userDisplay = new Vue({
        el: '#user-view',
        data: {
            id: null,
            current_id: null,
            errors: [],
            form: {},
        },
        computed: {
            isGuest: function() {
                return !window.currentUser;
            }
        },
        mounted: function () {
            this.id = this.$el.dataset.id;
            this.current_id = window.currentUser ? window.currentUser.get('username') : false;
            this.getUser();
        },
        methods: {
            getUser: function () {
                this.errors = [];
                axios.get('/api/user/' + this.id).then((response) => {
                    //initialize user
                    this.form = response.data;
                }, (error) => {
                    this.errors = error.response.data;
                    toastr.error("User Data couldn't be retrieve.", 'Users');
                });
            },
            refresh: function (type, event) {
                var parrentBlock = $('#list-' + type);
                var currentButton = $(event.currentTarget);
                this.errors = [];
                parrentBlock.addClass('block-opt-refresh');
                currentButton.prop('disabled', true);
                
                axios.get('/api/user/' + this.id + '/refresh').then((response) => {
                    //get last 3 items either for followers, or items, or ratings
                    this.form[type] = response.data[type];
                    parrentBlock.removeClass('block-opt-refresh');
                    currentButton.prop('disabled', false);
                }, (error) => {
                    this.errors = error.response.data;
                    toastr.error("User Data couldn't be retrieve.", 'Users');
                    parrentBlock.toggleClass('block-opt-refresh');
                    currentButton.prop('disabled', false);
                });
            },
            followActions: function (type) {
                if (this.isGuest) {
                    notify.guest("Please login to follow others.");
                } else {
                    this.errors = [];
                    axios.post('/api/user/' + this.id + '/' + type).then((response) => {
                        //update user
                        this.form = response.data;
                    }, (error) => {
                        this.errors = error.response.data;
                        toastr.error("Error occured during Follow/Unfollow action", 'Users');
                    });
                }
            },
        },
    });
}