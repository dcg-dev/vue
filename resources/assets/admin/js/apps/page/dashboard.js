if (document.getElementById('dashboard')) {
    window.dashboard = new Vue({
        el: '#dashboard',
        data: {
            info: null,
            earningsData: null,
            salesData: null,
            chartOption: {
                responsive: true,
                maintainAspectRatio: true
            },
            current: {
                users: {
                    type: 'today',
                    loading: false
                },
                items: {
                    type: 'today',
                    loading: false
                },
                processed_sales: {
                    type: 'today',
                    loading: false
                },
            }
        },
        watch: {
            'current.users.type': function (type) {
                this.setCurrent('users', type);
            },
            'current.items.type': function (type) {
                this.setCurrent('items', type);
            },
            'current.processed_sales.type': function (type) {
                this.setCurrent('processed_sales', type);
            },
        },
        mounted: function () {
            this.getDashboard();
        },
        methods: {
            getDashboard: function () {
                axios.get('/control/api/dashboard/info').then(function (response) {
                    var data = response.data;
                    data.items.top.forEach(function (v, i) {
                        data.items.top[i].item = new Item(v.item);
                    });

                    data.orders = (new Orders()).setResponse({
                        data: data.orders
                    });

                    dashboard.info = data;
                    dashboard.initializeStatistics();
                }, function () {
                    toastr.error('Error happened during obtaining Dashboard Information', 'Profile');
                });
            },
            refreshStatistics: function (type) {
                $('#' + type + '-statistics').addClass('block-opt-refresh');
                axios.get('/control/api/dashboard/statistics/' + type).then(function (response) {
                    Vue.set(dashboard.info.statistics, type, response.data);
                    $('#' + type + '-statistics').removeClass('block-opt-refresh');
                    dashboard.initializeStatistics();
                }, function () {
                    toastr.error('Error happened during obtaining Statistics Dashboard Information', 'Profile');
                    $('#' + type + '-statistics').removeClass('block-opt-refresh');
                });
            },
            setCurrent: function (group, type) {
                this.current[group] = {
                    type: type,
                    loading: true
                };
                axios.get('/control/api/dashboard/current/' + group + '/' + type).then(function (response) {
                    dashboard.info[group] = response.data;
                    dashboard.current[group]['loading'] = false;

                }, function () {
                    toastr.error('Error happened during obtaining Dashboard Information', 'Profile');
                    dashboard.current[group]['loading'] = false;
                });
            },
            initializeStatistics: function () {
                dashboard.earningsData = {
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
                            data: dashboard.info.statistics.earnings.last_week
                        },
                        {
                            label: 'This Week',
                            backgroundColor: 'rgba(68, 180, 166, .25)',
                            borderColor: 'rgba(68, 180, 166, .55)',
                            pointBorderColor: 'rgba(68, 180, 166, .55)',
                            pointBackgroundColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(68, 180, 166, 1)',
                            data: dashboard.info.statistics.earnings.current_week
                        }
                    ]
                };
                dashboard.salesData = {
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
                            data: dashboard.info.statistics.sales.last_week
                        },
                        {
                            label: 'This Week',
                            backgroundColor: 'rgba(164, 138, 212, .25)',
                            borderColor: 'rgba(164, 138, 212, .55)',
                            pointBorderColor: 'rgba(164, 138, 212, .55)',
                            pointBackgroundColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(164, 138, 212, 1)',
                            data: dashboard.info.statistics.sales.current_week
                        }
                    ]
                };
            }
        }
    });
}