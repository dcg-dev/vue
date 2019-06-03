(function () {
    this.SupportPosts = function () {
        Collection.call(this);
    };
    SupportPosts.prototype = Object.create(Collection.prototype);
    SupportPosts.prototype.constructor = SupportPosts;
    SupportPosts.prototype.model = function(attributes) {
        return new SupportPost(attributes);
    };
    SupportPosts.prototype.adminList = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/support/ticket/post/list' + params, success, error);
    };
}());

(function () { 
    this.SupportPost = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
            'ticket' : function(attributes) {
                return new SupportTicket(attributes);
            },
            'user' : function(attributes) {
                return new User(attributes);
            },
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);
        
        this.checkIsAdmin = function (userId) {
            if (!userId) {
                //user id should be attached
                return false;
            }
            return userId != this.get('user_id');
        };
        
        this.getTruncateText = function () {
            return new StringHelper(this.get('text')).truncate(20);
        };
    }
    SupportPost.prototype = Object.create(Model.prototype);
    SupportPost.prototype.constructor = SupportPost;
}());

window.support_posts = function () {
    return new SupportPosts();
};