(function () {
    PromoSubscriptions.prototype.all = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/promo-subscription/list' + params, success, error);
    }

    PromoSubscription.prototype.cancel = function(success, error) {
        axios.post('/control/api/promo-subscription/' + this.get('id') + '/cancel').then((response) => {
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