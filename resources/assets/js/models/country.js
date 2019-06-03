(function () {
    this.Countries = function () {
        Collection.call(this);
    }
    Countries.prototype = Object.create(Collection.prototype);
    Countries.prototype.constructor = Countries;
    Countries.prototype.model = function(attributes) {
        return new Country(attributes);
    }
}());

(function () {
    this.Country = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.oldAttributes = {};
        this.setAttributes(attributes);

        this.getVat = function () {
            return parseFloat(this.get('vat', 0.00));
        };

        this.calculateVat = function (value) {
            var coef = this.get('vat', 0.00) / 100;
            return parseFloat(value * coef).toFixed(2);
        };

        this.getPriceWithoutVat = function (value) {
            var coef = 1 - this.get('vat', 0.00) / 100;
            return parseFloat(value * coef).toFixed(2);
        };
    }
    Country.prototype = Object.create(Model.prototype);
    Country.prototype.constructor = Country;
}());

window.countries = function () {
    return new Countries();
};