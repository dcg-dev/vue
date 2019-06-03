(function () {
    AffiliateSales.prototype.requests = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/affiliate/request/list' + params, success, error);
    }
    
    AffiliateSales.prototype.sales = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/affiliate/sale/list' + params, success, error);
    }
    
    AffiliateSale.prototype.getEditUrl = function(type) {
        return '/control/affiliate/' + type + '/' + this.get('id') + '/edit';
    }
    
    AffiliateSale.prototype.closeRequest = function(success, error) {
        axios.post('/control/api/affiliate/request/' + this.get('id') + '/close').then((response) => {
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

}());