(function () {
    this.Plans = function () {
        Collection.call(this);
    }
    Plans.prototype = Object.create(Collection.prototype);
    Plans.prototype.constructor = Plans;
    Plans.prototype.model = function(attributes) {
        return new Plan(attributes);
    }
    Plans.prototype.all = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/api/billing/plan/list'+params, success, error);
    }
    Plans.prototype.center = function() {
        return this.count() > 3 ? false : 1;
    }
}());

(function () { 
    this.Plan = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
        };
        
        this.oldAttributes = {};
        this.setAttributes(attributes);
        
        this.getPrice = function () {
            return parseFloat(this.get('price', 0.00)).toFixed(2); 
        };
        
        this.getCommission = function () {
            return parseFloat(this.get('commission', 0.00)).toFixed(2); 
        };

        this.subscribe = function (plan, form, success, error) {
            axios.post('/api/billing/plan/' + plan + '/subscribe', form).then((response) => {
                if (success && typeof success === "function") {
                    success(response);
                }
            }, (response) => {
                if (error && typeof error === "function") {
                    error(response);
                }
            });
        };
    }
    Plan.prototype = Object.create(Model.prototype);
    Plan.prototype.constructor = Plan;
}());

window.plans = function () {
    return new Plans();
};