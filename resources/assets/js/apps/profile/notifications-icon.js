if (document.getElementById('profile-notifications-icon')) {
    window.profileNotificationsIcon = new Vue({
        el: '#profile-notifications-icon',
        data: {
            currentUser: false
        },
        mounted: function () {
            this.currentUser = currentUser;
        },
    });
}