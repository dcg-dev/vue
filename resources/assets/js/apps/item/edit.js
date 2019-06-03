if (document.getElementById('item-edit')) {
    window.itemEdit = new Vue({
        el: '#item-edit',
        data: {
            id: null,
            saving: false,
            successShow: false,
            scenario: 'edit',
            button: null,
            errors: [],
            formats: new Formats(),
            licenses: new Licenses(),
            form: {},
        },
        computed: {
            currentUser: function () {
                return currentUser;
            }
        },
        mounted: function () {
            this.id = this.$el.dataset.id;
            this.get();
            formats().all(function (list) {
                itemEdit.formats = list;
            });
            licenses().all(function (list) {
                itemEdit.licenses = list;
            });
        },
        methods: {
            headers: function () {
                var headers = window.ajaxHeaders;
                return headers;
            },
            get: function () {
                items().get('/api/item/' + this.id, function (item) {
                    itemEdit.form = item;
                });
            },
            setFree() {
                this.form.setFree();
                this.save();
            },
            ckeditorUpdate(value) {
                this.form.attributes.description = value;
                this.save();
            },
            save: function () {
                this.$refs.editor.instance.focusManager.blur(true);
                this.form.save('/api/item/' + this.id + '/edit', function (item) {
                    itemEdit.errors = [];
                }, function (error) {
                    if (error.response.status == 422) {
                        itemEdit.errors = error.response.data;
                    }
                });
            },
            publish: function () {
                axios.post('/api/item/' + this.id + '/publish').then((response) => {
                    itemEdit.errors = [];
                    this.successShow = true;
                    setTimeout(() => {
                        location.href = "/profile/items";
                    }, 1500);
                }, (error) => {
                    if (error.response.status == 422) {
                        itemEdit.errors = error.response.data;
                        toastr.error("Please, verify that you have entered the information correctly. Check the fields highlighted in red for valid data.", 'Item');
                    }
                });
            },
            formatChange: function (id, event) {
                if (event.target.checked) {
                    this.form.attachFormat(id);
                } else {
                    this.form.detachFormat(id);
                }
                this.save();
            },
            licenseChange: function (id, event) {
                if (event.target.checked) {
                    this.form.attachLicense(id);
                } else {
                    this.form.detachLicense(id);
                }
                this.save();
            },
            thumbnailError: function (file, error, xhr) {
                if (!Array.isArray(error)) {
                    toastr.error(error, 'Image');
                }
                this.errors = error;
                this.dropzoneClear('itemThumbnail');
            },
            thumbnailSuccess: function (file, response) {
                this.form = new Item(response);
                this.dropzoneClear('itemThumbnail');
                this.errors = [];
            },
            demoError: function (file, error, xhr) {
                if (!Array.isArray(error)) {
                    toastr.error(error, 'Demo file');
                }
                this.errors = error;
                this.dropzoneClear('itemDemo');
            },
            demoSuccess: function (file, response) {
                this.form = new Item(response);
                this.dropzoneClear('itemDemo');
                this.errors = [];
            },
            productError: function (file, error, xhr) {
                if (!Array.isArray(error)) {
                    toastr.error(error, 'Product file');
                }
                this.errors = error;
                this.dropzoneClear('itemProduct');
            },
            productSuccess: function (file, response) {
                this.form = new Item(response);
                this.dropzoneClear('itemProduct');
                this.errors = [];
            },
            dropzoneClear: function (id) {
                for (index in this.$children) {
                    var component = this.$children[index];
                    if (id == component.id) {
                        component.removeAllFiles();
                    }
                }
            },
            needFollow() {
                this.form.attributes.need_follow = !this.form.attributes.need_follow;
                this.save();
            }
        },
    });
}