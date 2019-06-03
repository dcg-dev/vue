if (document.getElementById('admin-plan-list')) {
    window.adminPlans = new Vue({
        el: '#admin-plan-list',
        data: {
            collection: new Plans(),
            plan: new Plan(),
            loading: false,
        },
        watch: {
        },
        mounted: function () {
            this.getList();
        },
        methods: {
            newPlan: function() {
                this.plan = new Plan();
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
                plans().all(function(collection) {
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
            }
        },
    });
}