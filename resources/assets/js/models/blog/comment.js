(function () {
    this.StoryComments = function () {
        Collection.call(this);
    }
    StoryComments.prototype = Object.create(Collection.prototype);
    StoryComments.prototype.constructor = StoryComments;
    StoryComments.prototype.model = function(attributes) {
        return new StoryComment(attributes);
    }
}());

(function () { 
    this.StoryComment = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
            'sender' : function(attributes) {
                return new User(attributes);
            },
            'story' : function(attributes) {
                return new Story(attributes);
            },
            'replies': function(data) {
                return (new StoryComments()).setResponse({
                    data: data
                });
            }
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);
        
        this.like = function(success, error) {
            axios.post('/api/blog/comment/' + this.get('id') + '/like').then((response) => {
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
            axios.post('/api/blog/comment/' + this.get('id') + '/replied', data).then((response) => {
                if (response.data) {
                    this.set('replies', (new StoryComments()).setResponse(response));
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
    StoryComment.prototype = Object.create(Model.prototype);
    StoryComment.prototype.constructor = StoryComment;
}());

window.story_comments = function () {
    return new StoryComments();
};