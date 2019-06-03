if (document.getElementById('billing-promotions')) {
    window.upgradeSubscriptions = new Vue({
        el: '#billing-promotions',
        data: {
        },
        computed: {
            currentUser: function() {
                return currentUser;
            }
        },
        mounted: function () {
        },
        methods: {
            modalBlogBook: function () {
                $('#modal-blog').modal('toggle');
            },
            modalBlogCreate: function () {
                $('#modal-create').modal('toggle');
            },
            booked: function () {
                var that = this;
                that.modalBlogBook();
                swal({
                    title: "Blog Post",
                    text: "You just bought possibility to create new Blog Post!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true
                }, function() {
                    that.modalBlogCreate();
                });
            }
        },
    });
}