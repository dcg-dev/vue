if (document.getElementById('admin-item-edit')) {
    window.adminItemEdit = new Vue({
        el: '#admin-item-edit',
        data: {
            id: null,
            formats: new Formats(),
            licenses: new Licenses(),
            form: {
                attributes: {}
            },
            errors: [],
            button: null,
            createMode: false,
        },
        watch: {
            'form.attributes.approved_at': function (value) {
                if(typeof value == 'number') {
                    this.form.attributes.approved_at = moment.unix(value).format('YYYY-MM-DD');
                }
            }
        },
        mounted: function () {
            this.id = this.$el.dataset.id;
            this.get();
        },
        methods: {
            get: function () {
                items().get('/api/item/' + this.id, function (item) {
                    adminItemEdit.form = item;
                    formats().all(function (list) {
                        adminItemEdit.formats = list;
                    });
                    licenses().all(function (list) {
                        adminItemEdit.licenses = list;
                    });
                }, null, {
                    'relations': [
                        'creator',
                        'tags',
                        'formats',
                        'licenses'
                    ]
                });
            },
            setFree: function () {
                this.form.setFree();
                this.save(this.createMode);
            },
            save: function (isCreateMode, event) {
                //if username was created
                this.$refs.editor.instance.focusManager.blur(true);
                let data = JSON.parse(JSON.stringify(this.form.attributes));
                data.approved_at = moment(data.approved_at).unix();
                if (!isCreateMode) {
                    this.errors = [];
                    if (!this.button && event) {
                        this.button = Ladda.create(event.target);
                    }
                    if (event) {
                        this.button.start();
                    }
                    var slug = this.form.isDirty('slug') ? this.form.oldAttributes.slug : this.form.attributes.slug;
                    axios.post('/control/api/item/' + slug + '/update', data).then((response) => {
                        if (response.data) {
                            toastr.info("Item has been successfully updated!", 'Item');
                            if (this.form.isDirty('slug')) {
                                location.href = '/control/item/' + this.form.get('slug') + '/edit';
                            }
                        }
                        if (event) {
                            adminItemEdit.button.stop();
                        }
                    }, function (error) {
                        if (error.response.status == 422) {
                            adminItemEdit.errors = error.response.data;
                            toastr.error("Please correct the input data and try again.", 'Item');
                        }
                        if (event) {
                            adminItemEdit.button.stop();
                        }
                    });
                }
            },
            formatChange: function (id, event) {
                if (event.target.checked) {
                    this.form.attachFormat(id);
                } else {
                    this.form.detachFormat(id);
                }
            },
            licenseChange: function (id, event) {
                if (event.target.checked) {
                    this.form.attachLicense(id);
                } else {
                    this.form.detachLicense(id);
                }
                this.save();
            },
            headers: function () {
                var headers = window.axios.defaults.headers.common;
                return headers;
            },
            updateFiles: function(response) {
                console.log(response);
                this.form.attributes.image = response.image;
                this.form.attributes.file = response.file;
                this.form.attributes.demo = response.demo;
                this.form.attributes.files = response.files;
            },
            thumbnailError: function (file, error, xhr) {
                if (!Array.isArray(error)) {
                    toastr.error(error, 'Image');
                }
                this.errors = error;
                this.dropzoneClear('itemThumbnail');
            },
            thumbnailSuccess: function (file, response) {
                this.updateFiles(response);
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
                this.updateFiles(response);
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
                this.updateFiles(response);
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
            }
        },
    });
}