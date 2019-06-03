if (document.getElementById('item-create')) {
    window.itemCreate = new Vue({
        el: '#item-create',
        data: {
            scenario: 'new',
            button: null,
            errors: [],
            form: {
                attributes: {}
            },
        },
        computed: {
            currentUser: function () {
                return currentUser;
            }
        },
        methods: {
            submit: function() {
                if(!currentUser.checkSellerProfile()) {
                    $(this.$refs.modalProfile.$el).modal('show');
                    return;
                }
                this.errors = [];
                this.$refs.editor.instance.focusManager.blur( true );
                axios.post('/api/item/create', this.form.attributes).then((response) => {
                    if (response.data) {
                        toastr.info("Item successfully created!", 'Items');
                        location.href='/item/'+response.data.slug+'/edit';
                    }
                }, (error) => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data;
                    }
                    if(error.response.status == 400) {
                        swal("Item",error.response.data.message ? error.response.data.message : error.response.data, "error");
                    }
                    console.log(error.response);
                });
            },
            ckeditorUpdate(value) {
                this.form.attributes.description = value;
                this.save();
            },
            save: function() {

            }
        },
    });
}