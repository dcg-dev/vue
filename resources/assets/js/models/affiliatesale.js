(function () {
    this.AffiliateSales = function () {
        Collection.call(this);
    };
    AffiliateSales.prototype = Object.create(Collection.prototype);
    AffiliateSales.prototype.constructor = AffiliateSales;
    AffiliateSales.prototype.model = function(attributes) {
        return new AffiliateSale(attributes);
    };
    AffiliateSales.prototype.all = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/api/affiliate/list' + params, success, error);
    };
    AffiliateSales.prototype.info = function (success, error) {
        this.call('/api/affiliate/info', success, error);
    };
}());

(function () { 
    this.AffiliateSale = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at', 'closed_at'
        ];
        this.relations = {
            'affiliable' : function(attributes) {
                if(this.affiliable_type == "App\\Models\\Subscription") { 
                    return new Subscription(attributes);
                } else {
                    return new OrderItem(attributes);
                }
            },
            'user': function(attributes) {
                return new User(attributes);
            },
            'affiliate_sales': function(data) {
                return (new AffiliateSales()).setResponse({
                    data: data
                });
            },
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);
    }
    AffiliateSale.prototype = Object.create(Model.prototype);
    AffiliateSale.prototype.constructor = AffiliateSale;
}());

window.affiliate_sales = function () {
    return new AffiliateSales();
};