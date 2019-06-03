(function () {
    this.Comments = function () {
        Collection.call(this);
    }
    Comments.prototype = Object.create(Collection.prototype);
    Comments.prototype.constructor = Comments;
    Comments.prototype.model = function(attributes) {
        return new Comment(attributes);
    }
}());

(function () { 
    this.Comment = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
            'sender' : function(attributes) {
                return new User(attributes);
            },
            'item' : function(attributes) {
                return new Item(attributes);
            },
            'replies': function(data) {
                return (new Comments()).setResponse({
                    data: data
                });
            }
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);
        
        this.like = function(success, error) {
            axios.post('/api/comment/'+this.get('id')+'/like').then((response) => {
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
        
        this.replied = function(data, success, error) {
            axios.post('/api/comment/'+this.get('id')+'/replied', data).then((response) => {
                if (response.data) {
                    this.set('replies', (new Comments()).setResponse(response));
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
    }
    Comment.prototype = Object.create(Model.prototype);
    Comment.prototype.constructor = Comment;
}());

window.comments = function () {
    return new Comments();
};