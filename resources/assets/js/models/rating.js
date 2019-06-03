(function () {
    this.Ratings = function () {
        Collection.call(this);
    }
    Ratings.prototype = Object.create(Collection.prototype);
    Ratings.prototype.constructor = Ratings;
    Ratings.prototype.model = function(attributes) {
        return new Rating(attributes);
    }
}());

(function () { 
    this.Rating = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
            'creator' : function(attributes) {
                return new User(attributes);
            },
            'item' : function(attributes) {
                return new Item(attributes);
            },
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);
    }
    Rating.prototype = Object.create(Model.prototype);
    Rating.prototype.constructor = Rating;
}());

window.ratings = function () {
    return new Ratings();
};