if (document.getElementById('admin-support-ticket-list')) {
    window.adminSupportTicketList = new Vue({
        el: '#admin-support-ticket-list',
        data: {
            collection: new Collection(),
            loading: false,
            search: null,
            columns: [{key: 'id', title: 'ID'},
                    {key: 'subject', title: 'Subject'},
                    {key: 'description', title: 'Description'},
                    {key: 'is_solved', title: 'Solved'},
                    {key: 'created_at', title: 'Created At'}],
            sortKey: 'id',
            sortOrders: {}
        },
        mounted: function () {
            var that = this;
            //initialize sorting asc/desc
            this.columns.forEach(function (column) {
                that.sortOrders[column.key] = -1;
            });
            this.getList(); 
        },
        methods: {
            getList: function() {
                this.loading = true;
                var that = this;
                support_tickets().adminList(function(collection) {
                    adminSupportTicketList.collection = collection;
                    adminSupportTicketList.loading = false;
                }, function() {
                    adminSupportTicketList.collection = new Collection();
                    adminSupportTicketList.loading = false;
                }, Object.assign({
                    'q': that.search,
                    'order': [that.sortKey + '|' + (that.sortOrders[that.sortKey] > 0 ? 'asc' : 'desc')],
                    'relations': [
                        'creator'
                    ]
                }, queryString.parse(location.search)));
            },
            page: function() {
                this.getList();
            },
            sortBy: function(key) {
                this.sortKey = key;
                this.sortOrders[key] *= -1;
                this.getList();
            },
            deleteTicket: function(ticket) {
                var that = this;
                swal({
                    title: "Delete ticket?",
                    text: ticket.get('subject'),
                    type: 'error',
                    confirmButtonColor: "#88c5e0",
                    confirmButtonText: "Delete",
                    showCancelButton: true
                }, function() {
                    that.loading = true;
                    ticket.delete(function() {
                        toastr.info('Support Ticket has been deleleted.');
                        that.loading = false;
                        that.getList();
                    }, function () {
                        toastr.error('Error happened during ticket deleting.');
                        that.loading = false;
                    });
                });
            },
        },
    });
}