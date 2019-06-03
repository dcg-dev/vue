(function () {
    Subscriptions.prototype.all = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/subscription/list' + params, success, error);
    }

    Subscription.prototype.cancel = function(success, error) {
        axios.post('/control/api/subscription/' + this.get('id') + '/cancel').then((response) => {
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