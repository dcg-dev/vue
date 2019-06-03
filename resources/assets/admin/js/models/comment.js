(function () {
    Comments.prototype.adminList = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/comment/list'+params, success, error);
    }
    Comment.prototype.delete = function(success, error) {
        axios.delete('/control/api/comment/' + this.get('id')).then((response) => {
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