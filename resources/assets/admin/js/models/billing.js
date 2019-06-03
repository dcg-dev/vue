(function () {
    Plans.prototype.all = function(success, error, params) { 
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/control/api/billing/plan/list'+params, success, error);
    }
    Plan.prototype.save = function(success, error) {
        var actions = this.isNew() ? 'create' : this.get('stripe_id')+'/update';
        axios.post('/control/api/billing/plan/'+actions, this.getAttributes()).then((response) => {
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
    Plan.prototype.delete = function(success, error) {
        axios.post('/control/api/billing/plan/'+this.get('stripe_id')+'/delete').then((response) => {
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

    PromoPlans.prototype.all = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/control/api/promo-plan/list'+params, success, error);
    }
    PromoPlan.prototype.save = function(success, error) {
        var actions = this.isNew() ? 'create' : this.get('id')+'/update';
        axios.post('/control/api/promo-plan/'+actions, this.getAttributes()).then((response) => {
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
    PromoPlan.prototype.delete = function(success, error) {
        axios.post('/control/api/promo-plan/'+this.get('id')+'/delete').then((response) => {
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