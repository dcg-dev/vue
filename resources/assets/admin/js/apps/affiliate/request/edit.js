if (document.getElementById('admin-affiliate-request-edit')) {
    window.adminAffiliateRequestEdit = new Vue({
        el: '#admin-affiliate-request-edit',
        data: {
            form: {
                attributes: {}
            },
            errors: [],
            button: null,
            loading: false,
            id: null
        },
        mounted: function () {
            this.id = this.$el.dataset.id;
            this.getRequest();
        },
        methods: {
            getRequest: function() {
                affiliate_sales().get('/control/api/affiliate/request/' + this.id, function(request) {
                    adminAffiliateRequestEdit.form = request;
                });
            },
            submit: function (event) {
                this.errors = [];
                if(!this.button) {
                    this.button = Ladda.create(event.target);
                }
                this.button.start();
                axios.post('/control/api/affiliate/request/' + this.form.attributes.id + '/update', this.form.attributes).then((response) => {
                    if (response.data) {
                        toastr.info("Affiliate Request been successfully updated!", 'Affiliate Request');
                        location.reload();
                    }
                    adminAffiliateRequestEdit.button.stop();
                }, function(error) {
                    if(error.response.status == 422) {
                        adminAffiliateRequestEdit.errors = error.response.data;
                        toastr.error("Please correct the input data and try again.", 'Affiliate Request');
                    }
                    adminAffiliateRequestEdit.button.stop();
                });
            },
        },
    });
}