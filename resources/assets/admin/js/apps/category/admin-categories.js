if (document.getElementById('admin-categories')) {
    window.adminCategories = new Vue({
        el: '#admin-categories',
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
                axios.get('/control/api/category/list').then((response) => {
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
                    adminCategories.resetModal();
                    $('#create-category').modal('hide');
                    adminCategories.getList();
                    button.ladda('stop');
                }, function(error) {
                    if(error.response.status == 422) {
                        adminCategories.errors.modal = error.response.data;
                        toastr.error("An error occured while authorizing! Please correct the input data and try again.", 'Authentication');
                    }
                    button.ladda('stop');
                });
            },
            save: function(data, callback, errorCallback) {
                axios.post('/control/api/category/store', data).then((response) => {
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
                this.save({
                    id: item_id,
                    index: index,
                });
            },
            remove: function(category) {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this category file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                }, function () {
                    axios.delete('/control/api/category/'+category.slug).then((response) => {
                        adminCategories.getList();
                    });
                });
            },
            addChild: function(category) {
                this.resetModal();
                this.forms.modal.procreator_id = category.id;
                $('#create-category').modal('show');
            },
            showCreate: function() {
                this.resetModal();
                $('#create-category').modal('show');
            },
            showEdit: function(category) {
                this.resetModal();
                this.forms.modal = category;
                $('#create-category').modal('show');
            },
            update: function(event) {
                var button = $(event.target);
                button.ladda();
                button.ladda('start');
                this.save(this.forms.modal, function() {
                    adminCategories.resetModal();
                    $('#create-category').modal('hide');
                    adminCategories.getList();
                    button.ladda('stop');
                }, function(error) {
                    if(error.response.status == 422) {
                        adminCategories.errors.modal = error.response.data;
                        toastr.error("An error occured while authorizing! Please correct the input data and try again.", 'Authentication');
                    }
                    button.ladda('stop');
                });
            },
        },
    });
}