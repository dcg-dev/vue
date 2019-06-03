if (document.getElementById('admin-plan-promotional')) {
    window.adminPlans = new Vue({
        el: '#admin-plan-promotional',
        data: {
            collection: new PromoPlans(),
            plan: new PromoPlan(),
            loading: false,
            blogPrice: null,
            configRoute: null
        },
        watch: {
        },
        mounted: function () {
            this.blogPrice = this.$el.dataset.blog_price;
            this.configRoute = this.$el.dataset.config_route;
            this.getList();
        },
        methods: {
            newPlan: function() {
                this.plan = new PromoPlan();
                $('#plan-modal').modal('show');
            },
            editPlan: function(plan) {
                this.plan = plan;
                $('#plan-modal').modal('show');
            },
            deletePlan: function(plan) {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this plan file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                }, function () {
                    plan.delete(function(){
                        adminPlans.getList();
                    });
                });
            },
            closeModal: function() {
                $('#plan-modal').modal('hide');
            },
            refresh: function() {
                this.closeModal();
                this.getList();
            },
            getList: function() {
                this.loading = true;
                promoPlans().all(function(collection) {
                    adminPlans.collection = collection;
                    adminPlans.loading = false;
                }, function(){
                    adminPlans.loading = false;
                }, Object.assign({
                    'relations': [
                    ]
                }, queryString.parse(location.search)));
            },
            page: function() {
                this.getList();
            },
            saveConfiguration: function () {
                if (this.configRoute && this.blogPrice) {
                    axios.post(this.configRoute, {'blog_price': this.blogPrice}).then((response) => {
                        if (response.data) {
                            toastr.info("Configuration has been updated successfully!", 'Promotional');
                        }
                    }, function(error) {
                        if(error.response.status == 422) {
                            adminPlans.errors = error.response.data;
                            toastr.error("Please correct the input data and try again.", 'Promotional');
                        }
                    });
                } else {
                    toastr.info("Config Route or Blog pricew was not set.", 'Promotional');
                }
            }
        },
    });
}