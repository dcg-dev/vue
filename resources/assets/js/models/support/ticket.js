(function () {
    this.SupportTickets = function () {
        Collection.call(this);
    };
    SupportTickets.prototype = Object.create(Collection.prototype);
    SupportTickets.prototype.constructor = SupportTickets;
    SupportTickets.prototype.model = function(attributes) {
        return new SupportTicket(attributes);
    };
    SupportTickets.prototype.adminList = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/control/api/support/ticket/list' + params, success, error);
    };
    SupportTickets.prototype.my = function(success, error) {
        this.list('/api/support/ticket/my', success, error);
    };
}());

(function () { 
    this.SupportTicket = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
            'posts': function (data) {
                return (new SupportPosts()).setResponse({
                    data: data
                });
            },
            'creator': function(attributes) {
                return new User(attributes);
            },
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);
        
        this.isSolved = function () {
            return this.get('is_solved');
        };

        this.getViewUrl = function () {
            return '/support/ticket/' + this.get('id');
        };
        
        this.getLastPost = function () {
            return new SupportPost(this.get('lastPost'));
        };
        
        this.getLastPostUser = function () {
            return this.get('lastPost') ? new User(this.get('lastPost').user) : null;
        };
        
        this.getTruncateDescription = function () {
            return new StringHelper(this.get('description')).truncate(100);
        };
        
        this.create = function(success, error) {
            axios.post('/api/support/ticket/create', this.getAttributes()).then((response) => {
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
        
        this.reply = function(text, success, error) {
            axios.post('/api/support/ticket/' + this.get('id') + '/reply', {text: text}).then((response) => {
                if (response.data) {
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
    SupportTicket.prototype = Object.create(Model.prototype);
    SupportTicket.prototype.constructor = SupportTicket;
}());

window.support_tickets = function () {
    return new SupportTickets();
};