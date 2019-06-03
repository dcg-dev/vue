if (document.getElementById('admin-item-create')) {
    window.adminItemCreate = new Vue({
        el: '#admin-item-create',
        data: {
            form: {
                attributes: {}
            },
            errors: [],
            button: null,
            createMode: true,
            loading: false
        },
        methods: {
            save: function (isCreateMode, event) {
                //if slug was not created
                if (isCreateMode) {
                    this.errors = [];
                    if(!this.button) {
                        this.button = Ladda.create(event.target);
                    }
                    this.button.start();
                    axios.post('/control/api/item/create', this.form.attributes).then((response) => {
                        if (response.data) {
                            //go to edit this item
                            toastr.info("Item has been successfully created!", 'Item');
                            location.href='/control/item/' + response.data.slug + '/edit';
                        }
                        adminItemCreate.button.stop();
                    }, function(error) {
                        if(error.response.status == 422) {
                            adminItemCreate.errors = error.response.data;
                            toastr.error("Please correct the input data and try again.", 'Item');
                        }
                        adminItemCreate.button.stop();
                    });
                } else {
                    toastr.error("Slug was not created, refresh the page.", 'Item');
                }
            },
        },
    });
}