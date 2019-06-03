(function () {
    this.Items = function () {
        Collection.call(this);
    }
    Items.prototype = Object.create(Collection.prototype);
    Items.prototype.constructor = Items;
    Items.prototype.model = function(attributes) {
        return new Item(attributes);
    }
    Items.prototype.all = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/api/item/list'+params, success, error);
    }
    Items.prototype.my = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/api/item/list/my'+params, success, error);
    } 
    Items.prototype.max = function(attribute, success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.call('/api/item/max/'+attribute+params, success, error);
    }
    Items.prototype.featured = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/api/item/list/featured'+params, success, error);
    }
}());

(function () {
    this.Item = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
            'creator': function(attributes) {
                return new User(attributes);
            },
            'comments': function(data) {
                return (new Comments()).setResponse({
                    data: data
                });
            },
            'ratings': function(data) {
                return (new Ratings()).setResponse({
                    data: data
                });
            },
            'tags': function(data) {
                return (new Tags()).setResponse({
                    data: data
                });
            },
            'formats': function(data) {
                return (new Formats()).setResponse({
                    data: data
                });
            },
            'filesize': function(bytes) {
                return window.file().size(bytes);
            },
            'licenses': function(data) {
                return (new Licenses()).setResponse({
                    data: data
                });
            },
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);
        
        this.isFree = function () {
            return !this.get('price');
        };
        
        this.isDeclined = function () {
            return this.get('status') === 3;
        };
        
        this.isApproved = function () {
            return this.get('status') === 2;
        };
        
        this.isReview = function () {
            return this.get('status') === 1;
        };
        
        this.isDraft = function () {
            return this.get('status') === 0;
        };
        
        this.setFree = function () {
            this.set('price', 0);
            return this;
        };
        
        this.hasFormat = function (id) {
            return (this.get('formatsIds').length && this.get('formatsIds').indexOf(id) !== -1);
        };
        
        this.hasImage = function (id) {
            return this.get('hasImage');
        };
        
        this.attachFormat = function (id) {
            if(this.get('formatsIds').indexOf(id) === -1) {
                return this.get('formatsIds').push(id);
            }
            return false;
        };
        
        this.detachFormat = function (id) {
            if(this.get('formatsIds').indexOf(id) !== -1) {
                return this.get('formatsIds').splice(this.get('formatsIds').indexOf(id),1); 
            }
            return false;
        };
        
        this.hasLicense = function (id) {
            return (this.get('licensesIds').length && this.get('licensesIds').indexOf(id) !== -1);
        };
        
        this.attachLicense = function (id) {
            if(this.get('licensesIds').indexOf(id) === -1) {
                return this.get('licensesIds').push(id);
            }
            return false;
        };
        
        this.detachLicense = function (id) {
            if(this.get('licensesIds').indexOf(id) !== -1) {
                return this.get('licensesIds').splice(this.get('licensesIds').indexOf(id),1); 
            }
            return false;
        };
        
        this.getTotalSales = function() {
            var value = parseFloat(this.get('total_sales', 0.00)).toFixed(2);
            return isNaN(value) ? 0.00 : value;
        };
        
        this.getPrice = function () {
            return parseFloat(this.get('price', 0.00)).toFixed(2);
        };
        
        this.getUrl = function () {
            return '/item/'+this.get('slug'); 
        };
        
        this.hasComments = function() {
            return typeof(this.get('comments')) != "undefined";
        };
        
        this.isFavourite = function() {
            return this.get('isFavourite');
        };

        this.isNeedFollow = function() {
            return this.isFree() && this.get('need_follow') && this.get('creator').canUsePro() && (!currentUser || this.get('creator_id') != currentUser.get('id'));
        };
        
        this.toFavourite = function(success, error) {
            axios.post('/api/item/'+this.get('slug')+'/favourite').then((response) => {
                if (response.data) {
                    this.setAttributes(response.data);
                    if (this.get('isFavourite')) {
                        notify.success(this.get('name') + ' has been added to favourites.', 'Favourites');
                    } else {
                        notify.info(this.get('name') + ' has been removed from favourites.', 'Favourites');
                    }
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
        
        this.commented = function(data, success, error) {
            data.order = ['created_at|desc'];
            axios.post('/api/item/'+this.get('slug')+'/commented', data).then((response) => {
                if (response.data) {
                    this.set('comments', (new Comments()).setResponse(response));
                    if(success && typeof success === "function") {
                        success(this.get('comments'), response);
                    }
                }
            }, (response) => {
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };
        
        this.comments = function(success, error, params) {
            params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
            if(!params.order) {
                params.order = ['created_at|desc']; 
            }
            axios.get('/api/item/'+this.get('slug')+'/comments'+params).then((response) => {
                if (response.data) {
                    this.set('comments', (new Comments()).setResponse(response));
                    if(success && typeof success === "function") {
                        success(this.get('comments'), response);
                    }
                }
            }, (response) => {
                this.set('comments', new Comments());
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };
        
        this.ratings = function(success, error, params) {
            params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
            axios.get('/api/item/'+this.get('slug')+'/ratings'+params).then((response) => {
                if (response.data) {
                    this.set('ratings', (new Ratings()).setResponse(response));
                    if(success && typeof success === "function") {
                        success(this.get('ratings'), response);
                    }
                }
            }, (response) => { 
                this.set('ratings', new Ratings());
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };

    }
    Item.prototype = Object.create(Model.prototype);
    Item.prototype.constructor = Item;
}());

window.items = function () {
    return new Items();
};