if (document.getElementById('admin-support-ticket-edit')) {
    window.adminSupportTicketEdit = new Vue({
        el: '#admin-support-ticket-edit',
        data: {
            form: {
                attributes: {}
            },
            errors: [],
            button: null,
            loading: false,
            id: null,
            replyText: null,
            currentViewPost: null
        },
        mounted: function () {
            this.id = this.$el.dataset.id;
            this.getTicket();
        },
        methods: {
            getTicket: function() {
                support_tickets().get('/control/api/support/ticket/' + this.id, function(request) {
                    adminSupportTicketEdit.form = request;
                });
            },
            submit: function (event) {
                this.errors = [];
                if(!this.button) {
                    this.button = Ladda.create(event.target);
                }
                this.button.start();
                this.$refs.editor.instance.focusManager.blur( true );
                axios.post('/control/api/support/ticket/' + this.form.attributes.id + '/update', this.form.attributes).then((response) => {
                    if (response.data) {
                        toastr.info("Support Ticket has been successfully updated!", 'Support Ticket');
                    }
                    adminSupportTicketEdit.button.stop();
                }, function(error) {
                    if(error.response.status == 422) {
                        adminAffiliateRequestEdit.errors = error.response.data;
                        toastr.error("Please correct the input data and try again.", 'Support Ticket');
                    }
                    adminSupportTicketEdit.button.stop();
                });
            },
            reply: function (event) {
                if(!this.button) {
                    this.button = Ladda.create(event.target);
                }
                this.$refs.editor2.instance.focusManager.blur( true );
                this.button.start();
                this.form.reply(this.replyText, function() {
                    toastr.info('You replied on the ticket successfully!', 'Support Ticket');
                    adminSupportTicketEdit.button.stop();
                    adminSupportTicketEdit.getTicket();
                }, function (error) {
                    toastr.error('Error happened during replying on the ticket.', 'Support Ticket');
                    adminSupportTicketEdit.button.stop();
                });
            },
            openModalPost: function (post) {
                this.currentViewPost = post;
                $("#modal-post").modal("show");
            }
        },
    });
}