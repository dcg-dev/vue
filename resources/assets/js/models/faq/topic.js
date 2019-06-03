(function () {
    this.FaqTopics = function () {
        Collection.call(this);
    };
    FaqTopics.prototype = Object.create(Collection.prototype);
    FaqTopics.prototype.constructor = FaqTopics;
    FaqTopics.prototype.model = function(attributes) {
        return new FaqTopic(attributes);
    };
    FaqTopics.prototype.adminList = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/support/faq/topic/list' + params, success, error);
    };
    FaqTopics.prototype.all = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/api/support/faq/topic/all' + params, success, error);
    };
}());

(function () { 
    this.FaqTopic = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
            'category' : function(attributes) {
                return new FaqCategory(attributes);
            },
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);
        
        this.getTruncateAnswer = function () {
            return new StringHelper(this.get('answer')).truncate(100);
        };
    }
    FaqTopic.prototype = Object.create(Model.prototype);
    FaqTopic.prototype.constructor = FaqTopic;
}());

window.faq_topics = function () {
    return new FaqTopics();
};