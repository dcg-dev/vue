if (document.getElementById('admin-affiliate-sale-edit')) {
    window.adminAffiliateSaleEdit = new Vue({
        el: '#admin-affiliate-sale-edit',
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
            this.getSale();
        },
        methods: {
            getSale: function() {
                affiliate_sales().get('/control/api/affiliate/sale/' + this.id, function(request) {
                    adminAffiliateSaleEdit.form = request;
                });
            },
            submit: function (event) {
                this.errors = [];
                if(!this.button) {
                    this.button = Ladda.create(event.target);
                }
                this.button.start();
                axios.post('/control/api/affiliate/sale/' + this.form.attributes.id + '/update', this.form.attributes).then((response) => {
                    if (response.data) {
                        toastr.info("Affiliate Sale been successfully updated!", 'Affiliate Sale');
                    }
                    adminAffiliateSaleEdit.button.stop();
                }, function(error) {
                    if(error.response.status == 422) {
                        adminAffiliateRequestEdit.errors = error.response.data;
                        toastr.error("Please correct the input data and try again.", 'Affiliate Sale');
                    }
                    adminAffiliateSaleEdit.button.stop();
                });
            },
        },
    });
}