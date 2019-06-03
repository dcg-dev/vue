if (document.getElementById('support-ticket-list')) {
    window.supportTicketList = new Vue({
        el: '#support-ticket-list',
        data: {
            tickets: new Collection(),
            loading: false
        },
        computed: {
            currentUser: function() {
                return currentUser;
            }
        },
        mounted: function () {
            this.getTickets();
        },
        methods: {
            getTickets: function () {
                var that = this;
                that.loading = true;
                support_tickets().my(function (list) {
                    that.tickets = list;
                    that.loading = false;
                }, function () {
                    that.tickets = new Collection();
                    toastr.error('Error has occured during Support Tickets obtaining', 'Support Tickets');
                    that.loading = false;
                });
            },
            openCreateModal: function () {
                $('#modal-create').modal('toggle');
            }
        }
    });
}