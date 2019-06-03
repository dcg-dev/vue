(function () {
    this.Licenses = function () {
        Collection.call(this);
    }
    Licenses.prototype = Object.create(Collection.prototype);
    Licenses.prototype.constructor = Licenses;
    Licenses.prototype.model = function(attributes) {
        return new License(attributes);
    }
    Licenses.prototype.all = function(success, error) {
        this.list('/api/license/all', success, error);
    }
}());

(function () {
    this.License = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.oldAttributes = {};
        this.setAttributes(attributes);
        
        this.getCoefficient = function () {
            return parseFloat(this.get('coefficient', 1)).toFixed(2); 
        };
        this.getPrice = function (price) {
            return (this.getCoefficient()*parseFloat(price)).toFixed(2); 
        };
    }
    License.prototype = Object.create(Model.prototype);
    License.prototype.constructor = License;
}());

window.licenses = function () {
    return new Licenses();
};