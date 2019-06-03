(function () {
    this.OrderStories = function () {
        Collection.call(this);
    }
    OrderStories.prototype = Object.create(Collection.prototype);
    OrderStories.prototype.constructor = OrderStories;
    OrderStories.prototype.model = function(attributes) {
        return new OrderStory(attributes);
    }
}());

(function () { 
    this.OrderStory = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
        };

        this.oldAttributes = {};
        this.setAttributes(attributes);
    }
    OrderStory.prototype = Object.create(Model.prototype);
    OrderStory.prototype.constructor = OrderStory;
}());

window.order_stories = function () {
    return new OrderStories();
};