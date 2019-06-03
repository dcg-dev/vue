(function () {
    this.ItemCollections = function () {
        Collection.call(this);
    }
    ItemCollections.prototype = Object.create(Collection.prototype);
    ItemCollections.prototype.constructor = ItemCollections;
    
    ItemCollections.prototype.model = function(attributes) {
        return new ItemCollection(attributes);
    }
    ItemCollections.prototype.all = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/api/collection/list'+params, success, error);
    }

    ItemCollections.prototype.user = function(slug, success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/api/user/'+slug+'/collections'+params, success, error);
    }
}());

(function () {
    this.ItemCollection = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
            'creator': function(attributes) {
                return new User(attributes);
            },
            'items': function(data) {
                return (new Items()).setResponse({
                    data: data
                });
            },
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);
        
        this.getUrl = function () {
            return '/collection/'+this.get('slug'); 
        };
        
        this.iFollow = function () {
            return this.get('iFollow') ? true : false;
        };
        
        this.follow = function(success, error) {
            axios.post('/api/collection/'+this.get('slug')+'/follow').then((response) => {
                if (response.data) {
                    this.setAttributes(response.data);
                    if(success && typeof success === "function") { 
                        success(this, response);
                    }
                }
            }, (response) => {
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };
        
        this.create = function(success, error) {
            axios.post('/api/collection/create', this.getAttributes()).then((response) => {
                if (response.data) {
                    this.setAttributes(response.data);
                    if(success && typeof success === "function") { 
                        success(this, response);
                    }
                }
            }, (response) => {
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };
        
        this.delete = function(success, error) {
            axios.post('/api/collection/'+this.get('slug')+'/delete').then((response) => {
                if (response.data) {
                    if(response.data.status) {
                        if(success && typeof success === "function") { 
                            success(response);
                        }
                    } else {
                        if(error && typeof error === "function") {
                            error(response);
                        }
                    }
                }
            }, (response) => {
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };
        
        this.attachItem = function(item_id, success, error) {
            axios.post('/api/collection/'+this.get('slug')+'/attach', {'item': item_id}).then((response) => {
                if (response.data) {
                    if(success && typeof success === "function") { 
                        success(response);
                    }
                }
            }, (response) => {
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };
        
        this.items = function(success, error, params) {
            params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
            axios.get('/api/collection/'+this.get('slug')+'/items'+params).then((response) => {
                if (response.data) {
                    this.set('items', (new Items()).setResponse(response));
                    if(success && typeof success === "function") {
                        success(this.get('items'), response);
                    }
                }
            }, (response) => {
                this.set('items', new Items());
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };
    }
    ItemCollection.prototype = Object.create(Model.prototype);
    ItemCollection.prototype.constructor = ItemCollection;
}());

window.itemCollections = function () {
    return new ItemCollections();
};