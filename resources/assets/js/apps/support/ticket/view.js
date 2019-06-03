if (document.getElementById('support-ticket-view')) {
    window.supportTicketView = new Vue({
        el: '#support-ticket-view',
        data: {
            id: null,
            ticket: false,
            button: null,
            loading: false,
            post: null
        },
        computed: {
            currentUser: function() {
                return currentUser;
            }
        },
        mounted: function () {
            this.id = this.$el.dataset.id; 
            this.getTicket();
        },
        methods: {
            getTicket: function () {
                var that = this;
                that.loading = true;
                support_tickets().get('/api/support/ticket/' + this.id, function(ticket) {
                    that.ticket = ticket;
                    that.loading = false;
                }, function() {
                    that.ticket = false;
                    that.loading = false;
                    toastr.error('Error has occured during Support Ticket obtaining', 'Support Ticket');
                }, {
                    'relations': [
                        'posts',
                    ]
                });
            },
            reply: function (event) {
                var that = this;
                this.$refs.editor.instance.focusManager.blur( true );
                that.ticket.reply(that.post, function() {
                    toastr.success('You replied on the ticket successfully!', 'Support Ticket');
                    that.getTicket();
                }, function (error) {
                    toastr.error('Error happened during replying on the ticket.', 'Support Ticket');
                });
            }
        }
    });
}