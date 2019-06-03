(function () {
    this.Messages = function () {
        Collection.call(this);
    }
    Messages.prototype = Object.create(Collection.prototype);
    Messages.prototype.constructor = Messages;
    Messages.prototype.model = function(attributes) {
        return new Message(attributes);
    }
    Messages.prototype.all = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/api/inbox/thread' + params, success, error);
    }
    Messages.prototype.deleted = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/api/inbox/thread/deleted' + params, success, error);
    }
    Messages.prototype.sent = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/api/inbox/thread/sent' + params, success, error);
    }
    Messages.prototype.archive = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/api/inbox/thread/archive' + params, success, error);
    }
    Messages.prototype.starred = function(success, error, params) {
        params = params ? '?' + queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/api/inbox/thread/starred' + params, success, error);
    }
}());

(function () {
    this.Message = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'updated_at'
        ];
        this.relations = {
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);
        this.getTruncateMessage = function (length) {
            if (!this.get('message')) {
                return '';
            }

            length = length || 100;
            var message = this.get('message').replace(/<[^>]+>/g, '');
            message = message.substring(0, length);
            return message.length < length ? message : message + '...';
        }
        this.getUser = function (currentUserId) {
            var user = _.find(this.get('users'), function (v) {
                return v.id != currentUserId;
            });

            if (!user) {
                user = _.find(this.get('users'), function (v) {
                    return v.id == currentUserId;
                });
            }

            user = new User(user);

            return user.getFullname();
        }
    }
    Message.prototype = Object.create(Model.prototype);
    Message.prototype.constructor = Message;
}());

window.messages = function () {
    return new Messages();
};