if (document.getElementById('profile-notifications')) {
    window.profileNotifications = new Vue({
        el: '#profile-notifications',
        data: {
            notifications: new Collection(),
            pagination: {
                total: 0,
                per_page: 10,
                from: 1,
                to: 0,
                current_page: 1
            }
        },
        mounted: function () {
            this.getNotifications(this.pagination.current_page, this.pagination.per_page);
        },
        methods: {
            getNotifications: function(page, per_page) {
                currentUser.notifications(function(list) {
                    profileNotifications.notifications = list;
                    profileNotifications.pagination = list;
                    profileNotifications.reloadUserNotifications();
                }, function() {
                    profileNotifications.notifications = new Collection();
                }, {
                    'page': page,
                    'per_page': per_page
                });
            },
            reloadUserNotifications: function () {
                users().current(function(user) {
                    window.currentUser.attributes.count_notifications = user.attributes.count_notifications;
                }, function() {
                    window.currentUser = false;
                });
            },
            toggleDialog: function(event) {
                var button = $(event.currentTarget);
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover these notifications!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: true
                }, function () {
                    button.prop('disabled', true);
                    //location reload contains inside function flushNotifications
                    currentUser.flushNotifications();
                });
            }
        }
    });
}