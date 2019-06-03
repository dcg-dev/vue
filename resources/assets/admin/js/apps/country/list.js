if (document.getElementById('admin-country-list')) {
    window.adminCountries = new Vue({
        el: '#admin-country-list',
        data: {
            countries: new Countries(),
            country: new Country(),
            loading: false,
        },
        mounted: function () {
            this.getList();
        },
        methods: {
            modal: function () {
                return $(this.$refs.form.$el);
            },
            create: function () {
                this.country = new Country();
                this.modal().modal('show');
            },
            edit: function (country) {
                this.country = country;
                this.modal().modal('show');
            },
            closeModal: function () {
                this.modal().modal('hide');
            },
            remove: function (country) {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this country!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                }, function () {
                    country.delete(function () {
                        adminCountries.getList();
                    });
                });
            },
            refresh: function () {
                this.closeModal();
                this.getList();
            },
            getList: function () {
                this.loading = true;
                countries().all(function (collection) {
                    adminCountries.countries = collection;
                    adminCountries.loading = false;
                }, function () {
                    adminCountries.loading = false;
                }, Object.assign({
                    'relations': []
                }, queryString.parse(location.search)));
            },
            page: function () {
                this.getList();
            }
        },
    });
}