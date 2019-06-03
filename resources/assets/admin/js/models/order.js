(function () {
    Order.prototype.getEditUrl = function(type) {
        return '/control/order/' + this.get('id') + '/edit';
    }
    Order.prototype.delete = function(success, error) {
        axios.delete('/control/api/order/' + this.get('id')).then((response) => {
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