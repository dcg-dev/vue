if (document.getElementById('profile-dashboard')) {
    window.profileDashboard = new Vue({
        el: '#profile-dashboard',
        data: {
            currentUser: false,
            info: null,
            earningsData: null,
            salesData: null,
            chartOption: {
                responsive:true,
                maintainAspectRatio:true
            }
        },
        mounted: function () {
            this.currentUser = currentUser;
            this.getDashboard();
        },
        methods: {
            getDashboard: function () {
                currentUser.getDashboard(function (response) {
                    profileDashboard.info = response.data;
                    profileDashboard.initializeStatistics();
                }, function () {
                    toastr.error('Error happened during obtaining Dashboard Information', 'Profile');
                });
            },
            refreshStatistics: function (type) {
                $('#' + type + '-statistics').addClass('block-opt-refresh');
                profileDashboard.currentUser.getStatistics(type, function (response) {
                    Vue.set(profileDashboard.info.statistics, type, response.data);
                    $('#' + type + '-statistics').removeClass('block-opt-refresh');
                    profileDashboard.initializeStatistics();
                }, function () {
                    toastr.error('Error happened during obtaining Statistics Dashboard Information', 'Profile');
                    $('#' + type + '-statistics').removeClass('block-opt-refresh');
                });
            },
            initializeStatistics: function () {
                profileDashboard.earningsData = {
                    labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
                    datasets: [
                        {
                            label: 'Last Week',
                            backgroundColor: 'rgba(68, 180, 166, .07)',
                            borderColor: 'rgba(68, 180, 166, .25)',
                            pointBorderColor: 'rgba(68, 180, 166, .25)',
                            pointBackgroundColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(68, 180, 166, 1)',
                            data: profileDashboard.info.statistics.earnings.last_week
                        },
                        {
                            label: 'This Week',
                            backgroundColor: 'rgba(68, 180, 166, .25)',
                            borderColor: 'rgba(68, 180, 166, .55)',
                            pointBorderColor: 'rgba(68, 180, 166, .55)',
                            pointBackgroundColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(68, 180, 166, 1)',
                            data: profileDashboard.info.statistics.earnings.current_week
                        }
                    ]
                };
                profileDashboard.salesData = {
                    labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
                    datasets: [
                        {
                            label: 'Last Week',
                            backgroundColor: 'rgba(164, 138, 212, .07)',
                            borderColor: 'rgba(164, 138, 212, .25)',
                            pointBorderColor: 'rgba(164, 138, 212, .25)',
                            pointBackgroundColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(164, 138, 212, 1)',
                            data: profileDashboard.info.statistics.sales.last_week
                        },
                        {
                            label: 'This Week',
                            backgroundColor: 'rgba(164, 138, 212, .25)',
                            borderColor: 'rgba(164, 138, 212, .55)',
                            pointBorderColor: 'rgba(164, 138, 212, .55)',
                            pointBackgroundColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(164, 138, 212, 1)',
                            data: profileDashboard.info.statistics.sales.current_week
                        }
                    ]
                };
            }
        }
    });
}