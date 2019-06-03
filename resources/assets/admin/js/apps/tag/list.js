if (document.getElementById('admin-tag-list')) {
    window.adminTags = new Vue({
        el: '#admin-tag-list',
        data: {
            collection: new Tags(),
            tag: new Tag(),
            loading: false,
        },
        watch: {
        },
        mounted: function () {
            this.getList();
        },
        methods: {
            create: function() {
                this.tag = new Tag();
                $('#tag-modal').modal('show');
            },
            edit: function(tag) {
                this.tag = tag;
                $('#tag-modal').modal('show');
            },
            remove: function(tag) {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this tag!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                }, function () {
                    tag.delete(function(){
                        adminTags.getList();
                    });
                });
            },
            closeModal: function() {
                $('#tag-modal').modal('hide');
            },
            refresh: function() {
                this.closeModal();
                this.getList();
            },
            getList: function() {
                this.loading = true;
                tags().all(function(collection) {
                    adminTags.collection = collection;
                    adminTags.loading = false;
                }, function(){
                    adminTags.loading = false;
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