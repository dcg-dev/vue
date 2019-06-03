if (document.getElementById('admin-order-edit')) {
    window.adminOrderEdit = new Vue({
        el: '#admin-order-edit',
        data: {
            form: {
                attributes: {}
            },
            errors: [],
            button: null,
            loading: false,
            id: null,
        },
        mounted: function () {
            this.id = this.$el.dataset.id;
            this.getOrder();
        },
        methods: {
            getOrder: function() {
                orders().get('/control/api/order/' + this.id, function(request) {
                    adminOrderEdit.form = request;
                });
            },
            submit: function (event) {
                this.errors = [];
                if(!this.button) {
                    this.button = Ladda.create(event.target);
                }
                this.button.start();
                axios.post('/control/api/order/' + this.form.attributes.id + '/update', this.form.attributes).then((response) => {
                    if (response.data) {
                        toastr.info("Order has been successfully updated!", 'Order');
                    }
                    adminOrderEdit.button.stop();
                }, function(error) {
                    if(error.response.status == 422) {
                        adminAffiliateRequestEdit.errors = error.response.data;
                        toastr.error("Please correct the input data and try again.", 'Order');
                    }
                    adminOrderEdit.button.stop();
                });
            }
        },
    });
}