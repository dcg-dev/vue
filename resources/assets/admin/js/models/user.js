(function () {
    Users.prototype.all = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/user/list' + params, success, error);
    }
    
    User.prototype.getEditUrl = function(success, error) {
        return '/control/user/' + this.get('username') + '/edit';
    }
    
    User.prototype.delete = function(success, error) {
        axios.delete('/control/api/user/' + this.get('username')).then((response) => {
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