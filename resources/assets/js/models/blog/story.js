(function () {
    this.Stories = function () {
        Collection.call(this);
    }
    Stories.prototype = Object.create(Collection.prototype);
    Stories.prototype.constructor = Stories;
    Stories.prototype.model = function(attributes) {
        return new Story(attributes);
    }
    Stories.prototype.all = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/api/blog/story/list' + params, success, error);
    }
    Stories.prototype.book = function(form, success, error) {
        axios.post('/api/blog/story/book', form).then((response) => {
            if(response.data && success && typeof success === "function") {
                success(response.data);
            }
        }, (response) => {
            if(error && typeof error === "function") {
                error(response);
            }
        });
    }
}());

(function () {
    this.Story = function (attributes) {
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
                return (new StoryComments()).setResponse({
                    data: data
                });
            }
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);
        
        this.isApproved = function () {
            return this.get('approved');
        };
        
        this.loadingLike = false;
        
        this.hasImage = function (id) {
            return this.get('hasImage');
        };
        
        this.getUrl = function () {
            return '/blog/story/' + this.get('slug'); 
        };
        
        this.getPublishUrl = function () {
            return '/blog/story/' + this.get('slug') + '/publish'; 
        };
        
        this.getShortText = function(length) {
            length = !length ? 200 : length;
            var dom = document.createElement("DIV");
            dom.innerHTML = this.get('text');
            var plainText = (dom.textContent || dom.innerText);
            return plainText.length > length ? plainText.substr(0, length) + "..." : plainText;
        }
        
        this.likeStory = function(data, success, error) {
            this.loadingLike = true;
            axios.post('/api/blog/story/' + this.get('slug') + '/like', data).then((response) => {
                if (response.data) {
                    this.setAttributes(response.data);
                    if(success && typeof success === "function") {
                        success(this, response);
                    }
                }
                this.loadingLike = false;
            }, (response) => {
                if(error && typeof error === "function") {
                    error(response);
                }
                this.loadingLike = false;
            });
        };
        
        this.hasComments = function() {
            return typeof(this.get('comments')) != "undefined";
        };
        
        this.commented = function(data, success, error) {
            axios.post('/api/blog/story/' + this.get('slug') + '/commented', data).then((response) => {
                if (response.data) {
                    this.set('comments', (new StoryComments()).setResponse(response));
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
            params = params ? '?' + queryString.stringify(params,{arrayFormat: 'index'}) : '';
            axios.get('/api/blog/story/' + this.get('slug') + '/comments' + params).then((response) => {
                if (response.data) {
                    this.set('comments', (new StoryComments()).setResponse(response));
                    if(success && typeof success === "function") {
                        success(this.get('comments'), response);
                    }
                }
            }, (response) => {
                this.set('comments', new StoryComments());
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };
        
        this.getImageUrl = function (success, error, params) {
            return '/api/blog/story/' + this.get('slug') + '/image';
        };
        
        this.publish = function(url, success, error) {
            axios.post(url, this.getAttributes()).then((response) => {
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
            axios.post('/api/blog/story/create', this.getAttributes()).then((response) => {
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
        
    }
    Story.prototype = Object.create(Model.prototype);
    Story.prototype.constructor = Story;
}());

window.stories = function () {
    return new Stories();
};