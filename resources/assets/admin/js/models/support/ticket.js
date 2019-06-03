(function () {
    SupportTicket.prototype.getEditUrl = function(type) {
        return '/control/support/ticket/' + this.get('id') + '/edit';
    }
    SupportTicket.prototype.delete = function(success, error) {
        axios.delete('/control/api/support/ticket/' + this.get('id')).then((response) => {
            if (response.data) {
                if(response.data.status) {
                    if(success && typeof success === "function") { 
                        success(response);
                    }
                } else {
                    if(error && typeof error === "function") {
                        error(response);
                    }
                }
            }
        }, (response) => {
            if(error && typeof error === "function") {
                error(response);
            }
        });
    }
}());