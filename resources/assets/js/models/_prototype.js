(function () {
    this.Model = function () {}

    Model.prototype.__getattr__ = function(key) {
        return this.get(key);
    }

    Model.prototype.attributes = {};

    Model.prototype.set = function(key, value) {
        var key = JSON.parse(JSON.stringify(key));
        if(this.relations && this.relations[key]) {
            var relation = JSON.parse(JSON.stringify(key));
            try {
                value = this.relations[key](value);
            } catch(error) {
                console.log("Relation callback error!");
            }
            key=relation;
        } else if(Array.isArray(this.dates) && this.dates.length && this.dates.indexOf(key) !== -1) {
            if(parseInt(value) > 0) {
                value = moment.unix(value);
            } else {
                value = value;
            }
        }
        this.attributes[key] = value;
        return this;
    }

    Model.prototype.get = function(key, defaultValue) {
        defaultValue = typeof(defaultValue) == 'undefined' ? false : defaultValue;
        if(key in this.attributes) {
            if(defaultValue && !this.attributes[key]) {
                return defaultValue;
            }
            return this.attributes[key];
        }
        return defaultValue;
    }

    Model.prototype.old = function(key, defaultValue) {
        defaultValue = typeof(defaultValue) == 'undefined' ? false : defaultValue;
        return key in this.oldAttributes && this.oldAttributes[key] ? this.oldAttributes[key] : defaultValue;
    }

    Model.prototype.isDirty = function(key) {
        if(key) {
            if(typeof(this.relations[key]) != 'undefined' || typeof(this.attributes[key]) ==  'undefined') {
                return false;
            }
            var current = JSON.parse(JSON.stringify(this.attributes[key])),
                    old = JSON.parse(JSON.stringify(this.oldAttributes[key]));
            return Array.isArray(current) ? !new ArrayHelper().equal(current, old) : current !== old;
        }
        for(key in this.getAttributes()) {
            if(this.isDirty(key)) {
                return true;
            }
        }
        return false;
    }

    Model.prototype.is = function(id) {
        return this.get('id') == id;
    }

    Model.prototype.bool = function(key) {
        return this.get(key) ? true : false;
    }

    Model.prototype.getDirty = function(key) {
        var result = {};
        for(key in this.getAttributes()) {
            if(this.isDirty(key)) {
                result[key] = this.get(key);
            }
        }
        return result;
    }

    Model.prototype.getAttributes = function() {
        return this.attributes;
    }

    Model.prototype.setAttributes = function(attributes) {
        for(key in attributes) {
            var key = JSON.parse(JSON.stringify(key));
            var value = attributes[key];
            this.set(key, value);
            this.oldAttributes[key] = JSON.parse(JSON.stringify(this.get(key)));
        }
        if(this.relations) {
            for(relation in this.relations) {
                if(!this.get(relation) || typeof(this.get(relation)) == 'undefined') {
                    this.attributes[relation] = this.relations[relation]();
                }
            }
        }
        return this;
    }

    Model.prototype.isNew = function() {
        return this.get('id') <= 0;
    }

    Model.prototype.save = function(url, success, error) {
        if(!this.isDirty()) {
            success(this);
            return;
        }
        axios.post(url, this.getDirty()).then((response) => {
            if (response.data && success) {
                this.setAttributes(response.data);
                success(this, response);
            }
        }, (response) => {
            if(error) {
                error(response);
            }
        });
    }
}());

(function () {
    this.Collection = function () { }
    Collection.prototype.current_page = 1;
    Collection.prototype.from = 0;
    Collection.prototype.last_page = 1;
    Collection.prototype.to = 0;
    Collection.prototype.total = 0;
    Collection.prototype.next_page_url = null;
    Collection.prototype.per_page = 20;
    Collection.prototype.prev_page_url = null;
    Collection.prototype.data = [];
    Collection.prototype.get = function(url, success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        axios.get(url+params).then((response) => {
            if (response.data && success) {
                success(this.model(response.data), response);
            }
        }, (response) => {
            if(error) {
                error(response);
            }
        });
    }
    Collection.prototype.isFirstPage = function() {
        return this.current_page == 1;
    }
    Collection.prototype.isLastPage = function() {
        return this.current_page == this.last_page;
    }
    Collection.prototype.hasPages = function() {
        return this.total > this.per_page;
    }

    Collection.prototype.isEmpty = function() {
        return !this.data.length;
    }

    Collection.prototype.getData = function() {
        return this.data;
    }

    Collection.prototype.count = function() {
        return this.getData().length;
    }

    Collection.prototype.index = function(index) {
        return this.getData()[index];
    }

    Collection.prototype.first = function() {
        return this.getData()[0];
    }

    Collection.prototype.last = function() {
        return this.getData()[this.getData().length-1];
    }

    Collection.prototype.find = function(value, key) {
        var key = !key ? 'id' : key;
        for(index in this.getData()) {
            var item = this.getData()[index];
            if(item.get(key) == value) {
                return item;
            }
        }
        return false;
    }

    Collection.prototype.pluck = function (key) {
        var key = !key ? 'id' : key;
        var results = [];
        for (index in this.getData()) {
            results.push(this.getData()[index].get(key));
        }
        return results;
    }

    Collection.prototype.push = function(value) {
        var model = this.model(value);
        this.data.push(model);
        return model;
    }

    Collection.prototype.setAttributes = function(attributes) {
        for(key in attributes) {
            this[key] = attributes[key];
        }
        return this;
    }

    Collection.prototype.setResponse = function(response) {
        if (response && typeof(response.data) != 'undefined') {
                var results = [];
                var items = [];
                if(Array.isArray(response.data)) {
                    items = response.data;
                } else {
                    items = response.data.data;
                }
                for(index in items) {
                    results.push(this.model(items[index]));
                }
                if(Array.isArray(response.data)) {
                    return this.setAttributes({data: results});
                }
                response.data.data = results;
                return this.setAttributes(response.data);
        }
        return this;
    }

    Collection.prototype.list = function(url, success, error) {
        axios.get(url).then((response) => {
            if(!success || typeof success !== "function") {
                return;
            }
            if (response.data) {
                success(this.setResponse(response), response);
            }
        }, (response) => {
            if(error && typeof error === "function") {
                error(response);
            }
        });
    }

    Collection.prototype.call = function(url, success, error) {
        axios.get(url).then((response) => {
            if(!success || typeof success !== "function") {
                return;
            }
            if (response.data) {
                success(response.data, response);
            }
        }, (response) => {
            if(error && typeof error === "function") {
                error(response);
            }
        });
    }
}());