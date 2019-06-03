(function () {
    this.Orders = function () {
        Collection.call(this);
    }
    Orders.prototype = Object.create(Collection.prototype);
    Orders.prototype.constructor = Orders;
    Orders.prototype.model = function(attributes) {
        return new Order(attributes);
    }
    Orders.prototype.adminList = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/order/list' + params, success, error);
    }
}());

(function () { 
    this.Order = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
            'customer': function(attributes) {
                return new User(attributes);
            },
            'items': function(data) {
                return (new OrderItems()).setResponse({
                    data: data
                });
            },
            'story': function(attributes) {
                return new OrderStory(attributes);
            },
        };

        this.oldAttributes = {};
        this.setAttributes(attributes);
    }
    Order.prototype = Object.create(Model.prototype);
    Order.prototype.constructor = Order;
}());

window.orders = function () {
    return new Orders();
};