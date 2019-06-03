(function () {
    this.PromoPlans = function () {
        Collection.call(this);
    }
    PromoPlans.prototype = Object.create(Collection.prototype);
    PromoPlans.prototype.constructor = PromoPlans;
    PromoPlans.prototype.model = function(attributes) {
        return new PromoPlan(attributes);
    }
    PromoPlans.prototype.all = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/api/billing/plan/promo'+params, success, error);
    }
}());

(function () { 
    this.PromoPlan = function (attributes) {
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

        this.buy = function (plan, form, success, error) {
            axios.post('/api/promo-plan/' + plan + '/buy', form).then((response) => {
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
    PromoPlan.prototype = Object.create(Model.prototype);
    PromoPlan.prototype.constructor = PromoPlan;
}());

window.promoPlans = function () {
    return new PromoPlans();
};