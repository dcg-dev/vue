(function () {
    Items.prototype.adminList = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/item/list'+params, success, error);
    }
    Item.prototype.delete = function(success, error) {
        axios.delete('/control/api/item/' + this.get('slug')).then((response) => {
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
    Item.prototype.approve = function(success, error) {
        axios.post('/control/api/item/' + this.get('slug') + '/approve').then((response) => {
            if (response.data) {
                this.setAttributes(response.data);
                if(success && typeof success === "function") {
                    success(this, response);
                }
            }
        }, (response) => {
            if(error && typeof error === "function") {
                error(response);
            }
        });
    }
    Item.prototype.decline = function(reason, success, error) {
        axios.post('/control/api/item/' + this.get('slug') + '/decline', {'reason' : reason}).then((response) => {
            if (response.data) {
                this.setAttributes(response.data);
                if(success && typeof success === "function") {
                    success(this, response);
                }
            }
        }, (response) => {
            if(error && typeof error === "function") {
                error(response);
            }
        });
    }
    Item.prototype.getEditUrl = function(success, error) {
        return '/control/item/' + this.get('slug') + '/edit';
    } 
}());