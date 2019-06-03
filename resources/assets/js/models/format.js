(function () {
    this.Formats = function () {
        Collection.call(this);
    }
    Formats.prototype = Object.create(Collection.prototype);
    Formats.prototype.constructor = Formats;
    Formats.prototype.model = function(attributes) {
        return new Format(attributes);
    }
    Formats.prototype.all = function(success, error) {
        this.list('/api/format/all', success, error);
    }
}());

(function () {
    this.Format = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.oldAttributes = {};
        this.setAttributes(attributes);
    }
    Format.prototype = Object.create(Model.prototype);
    Format.prototype.constructor = Format;
}());

window.formats = function () {
    return new Formats();
};