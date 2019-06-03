(function () {
    this.Tags = function () {
        Collection.call(this);
    }
    Tags.prototype = Object.create(Collection.prototype);
    Tags.prototype.constructor = Tags;
    Tags.prototype.model = function(attributes) {
        return new Tag(attributes);
    }
    Tags.prototype.all = function(success, error) {
        this.list('/api/tag/list', success, error);
    }
}());

(function () {
    this.Tag = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.oldAttributes = {};
        this.setAttributes(attributes);
    }
    Tag.prototype = Object.create(Model.prototype);
    Tag.prototype.constructor = Tag;
}());

window.tags = function () {
    return new Tags();
};