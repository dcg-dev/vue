(function () {
    Ratings.prototype.adminList = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/rating/list'+params, success, error);
    }
    Rating.prototype.delete = function(success, error) {
        axios.delete('/control/api/rating/' + this.get('id')).then((response) => {
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