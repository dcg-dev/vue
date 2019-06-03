(function () {
    this.PromoSubscriptions = function () {
        Collection.call(this);
    }
    PromoSubscriptions.prototype = Object.create(Collection.prototype);
    PromoSubscriptions.prototype.constructor = PromoSubscriptions;
    PromoSubscriptions.prototype.model = function(attributes) {
        return new PromoSubscription(attributes);
    }
}());

(function () { 
    this.PromoSubscription = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at', 'ends_at'
        ];
        this.relations = {
            'customer': function(attributes) {
                return new User(attributes);
            },
            'plan': function(attributes) {
                return new PromoPlan(attributes);
            },
            'items': function(attributes) {
                return (new Items()).setResponse({
                    data: attributes
                });
            },
        };
        
        this.oldAttributes = {};
        this.setAttributes(attributes);
        
        this.valid = function() {
            return this.active() || this.onTrial() || this.onGracePeriod();
        };

        this.active = function() {
            return !this.get('ends_at', false) || this.onGracePeriod();
        };
    }
    PromoSubscription.prototype = Object.create(Model.prototype);
    PromoSubscription.prototype.constructor = PromoSubscription;
}());

window.promoSubscriptions = function () {
    return new PromoSubscriptions();
};