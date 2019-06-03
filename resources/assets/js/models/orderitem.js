(function () {
    this.OrderItems = function () {
        Collection.call(this);
    }
    OrderItems.prototype = Object.create(Collection.prototype);
    OrderItems.prototype.constructor = OrderItems;
    OrderItems.prototype.model = function(attributes) {
        return new OrderItem(attributes);
    }
    OrderItems.prototype.all = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/api/order/list' + params, success, error);
    }
    OrderItems.prototype.purchased = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/api/order/purchased' + params, success, error);
    }
    OrderItems.prototype.billing = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/api/order/billing' + params, success, error);
    }
}());

(function () { 
    this.OrderItem = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
            'item' : function(attributes) {
                return new Item(attributes);
            },
            'license' : function(attributes) {
                return new License(attributes);
            },
        };

        this.addRating = function(form, success, errors, params) {
            params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
            axios.post('/api/item/'+this.get('item').get('slug')+'/ratings'+params, form).then((response) => {
                if (response.data) {
                    this.get('item').set('ratings', (new Ratings()).setResponse(response));
                    if(success && typeof success === "function") {
                        success(this.get('ratings'), response);
                    }
                }
            }, (response) => {
                this.get('item').set('rating', new Ratings());
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        }

        this.oldAttributes = {};
        this.setAttributes(attributes);

        this.getVat = function () {
            return parseFloat(this.get('vat', 0.00));
        };
    }
    OrderItem.prototype = Object.create(Model.prototype);
    OrderItem.prototype.constructor = OrderItem;
}());

window.order_items = function () {
    return new OrderItems();
};