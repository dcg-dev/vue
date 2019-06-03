(function () {
    Countries.prototype.all = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/control/api/country/list'+params, success, error);
    }
    Country.prototype.save = function(success, error) {
        axios.post('/control/api/country/store', this.getAttributes()).then((response) => {
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
    Country.prototype.delete = function(success, error) {
        axios.delete('/control/api/country/'+this.get('id')).then((response) => {
            if (response.data) {
                if(success && typeof success === "function") {
                        success(response);
                    }
                }
        }, (response) => {
            if(error && typeof error === "function") {
                error(response);
            }
        });
    }
}());