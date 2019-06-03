(function () {
    this.Categories = function () {
        Collection.call(this);
    }
    Categories.prototype = Object.create(Collection.prototype);
    Categories.prototype.constructor = Categories;

    Categories.prototype.model = function (attributes) {
        return new Category(attributes);
    }
    Categories.prototype.all = function (success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/api/category/list' + params, success, error);
    }

    Categories.prototype.search = function (params) {
        params = params ? '?' + (typeof params == 'object' ? objectToQuery(params) : params) : '';
        var instanse = this;
        return new Promise(function (resolve, reject) {
            axios.get('/api/category/list' + params).then(function (response) {
                resolve(instanse.setResponse(response), response);
            }).catch(function (error) {
                reject(error);
            });
        });
    }
}());

(function () {
    this.Category = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
            'childs': function (data) {
                return (new Categories()).setResponse({
                    data: data
                });
            },
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);

        this.getUrl = function () {
            return '/category/' + this.get('slug');
        };
    }
    Category.prototype = Object.create(Model.prototype);
    Category.prototype.constructor = Category;
}());

window.categories = function () {
    return new Categories();
};