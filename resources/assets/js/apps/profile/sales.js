if (document.getElementById('sales')) {
    window.profileSettings = new Vue({
        el: '#sales',
        data: {
            counts: {}
        },
        mounted: function () {
            this.getCounts();
        },
        methods: {
            getCounts: function () {
                axios.get('/api/order/counts').then((response) => {
                    this.counts = response.data;
                }, (error) => {
                });
            }
        },
    });
}