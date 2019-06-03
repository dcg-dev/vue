(function () {
    this.Favourites = function () {
        Collection.call(this);
    }
    Favourites.prototype = Object.create(Collection.prototype);
    Favourites.prototype.constructor = Favourites;
    Favourites.prototype.model = function(attributes) {
        return new Favourite(attributes);
    }
}());

(function () { 
    this.Favourite = function (attributes) {
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
    Favourite.prototype = Object.create(Model.prototype);
    Favourite.prototype.constructor = Favourite;
}());

window.favourites = function () {
    return new Favourites();
};