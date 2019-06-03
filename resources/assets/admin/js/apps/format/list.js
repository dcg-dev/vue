if (document.getElementById('admin-format-list')) {
    window.adminFormat = new Vue({
        el: '#admin-format-list',
        data: {
            list: {},
            loading: {
                list: false
            },
            forms: {
                modal: {},
            },
            errors: {
                modal: [],
            }
        },
        watch: {
        },
        mounted: function () {
            this.getList();
        },
        methods: {
            getList: function(callback, errorCallback) {
                if(this.loading.list) {
                    if(errorCallback) {
                        errorCallback();
                    }
                    toastr.error('Sorry, the list is currently loading. Try again after the list is loaded.', 'Categories');
                    return;
                }
                this.loading.list = true;
                axios.get('/control/api/format/list').then((response) => {
                    if (response.data) {
                        this.list = response.data;
                        if(callback) {
                            callback();
                        }
                        this.loading.list = false;
                    }
                }, (error) => {
                    if(errorCallback) {
                        errorCallback();
                    }
                    this.loading.list = false;
                });
            },
            resetModal: function() {
                this.forms.modal = {};
                this.errors.modal = [];
            },
            submit: function(event) {
                var button = $(event.target);
                button.ladda();
                button.ladda('start');
                this.save(this.forms.modal, function() {
                    adminFormat.resetModal();
                    $('#format-modal').modal('hide');
                    adminFormat.getList();
                    button.ladda('stop');
                }, function(error) {
                    if(error.response.status == 422) {
                        adminFormat.errors.modal = error.response.data;
                        toastr.error("An error occured while authorizing! Please correct the input data and try again.", 'Authentication');
                    }
                    button.ladda('stop');
                });
            },
            save: function(data, callback, errorCallback) {
                axios.post('/control/api/format/store', data).then((response) => {
                    if(callback) {
                        callback(response);
                    }
                }, (error) => {
                    if(errorCallback) {
                        errorCallback(error);
                    }
                });
            },
            move: function(event){
                if(event.newIndex == event.oldIndex) {
                    return;
                }
                var item_id = event.item.dataset.id;
                var index = event.newIndex + 1;

                axios.post('/control/api/format/sort', {
                    id: item_id,
                    index: index,
                }).then((response) => {
                }, (error) => {
                });
            },
            remove: function(format) {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this format file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                }, function () {
                    axios.delete('/control/api/format/'+format.slug).then((response) => {
                        adminFormat.getList();
                    });
                });
            },
            showCreate: function() {
                this.resetModal();
                $('#format-modal').modal('show');
            },
            showEdit: function(format) {
                this.resetModal();
                this.forms.modal = format;
                $('#format-modal').modal('show');
            },
            update: function(event) {
                var button = $(event.target);
                button.ladda();
                button.ladda('start');
                this.save(this.forms.modal, function() {
                    adminFormat.resetModal();
                    $('#format-modal').modal('hide');
                    adminFormat.getList();
                    button.ladda('stop');
                }, function(error) {
                    if(error.response.status == 422) {
                        adminFormat.errors.modal = error.response.data;
                        toastr.error("An error occured while authorizing! Please correct the input data and try again.", 'Authentication');
                    }
                    button.ladda('stop');
                });
            },
        },
    });
}