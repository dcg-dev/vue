(function () {
    this.FaqCategories = function () {
        Collection.call(this);
    };
    FaqCategories.prototype = Object.create(Collection.prototype);
    FaqCategories.prototype.constructor = FaqCategories;
    FaqCategories.prototype.model = function(attributes) {
        return new FaqCategory(attributes);
    };
    FaqCategories.prototype.adminList = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/support/faq/category/list' + params, success, error);
    };
    FaqCategories.prototype.adminAll = function(success, error) {
        this.list('/control/api/support/faq/category/all', success, error);
    };
}());

(function () { 
    this.FaqCategory = function (attributes) {
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
    FaqCategory.prototype = Object.create(Model.prototype);
    FaqCategory.prototype.constructor = FaqCategory;
}());

window.faq_categories = function () {
    return new FaqCategories();
};