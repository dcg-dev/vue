(function () {
    this.Subscriptions = function () {
        Collection.call(this);
    }
    Subscriptions.prototype = Object.create(Collection.prototype);
    Subscriptions.prototype.constructor = Subscriptions;
    Subscriptions.prototype.model = function (attributes) {
        return new Subscription(attributes);
    }

    Subscriptions.prototype.list = function (params) {
        params = params ? '?' + (typeof params == 'object' ? objectToQuery(params) : params) : '';
        var instanse = this;
        return new Promise(function (resolve, reject) {
            axios.get('/control/api/subscription/list' + params).then(function (response) {
                resolve(instanse.setResponse(response), response);
            }).catch(function (error) {
                reject(error);
            });
        });
    }
}());

(function () {
    this.Subscription = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at', 'ends_at', 'trial_ends_at'
        ];
        this.relations = {
            'customer': function (attributes) {
                return new User(attributes);
            },
        };

        this.oldAttributes = {};
        this.setAttributes(attributes);

        this.getPrice = function () {
            return parseFloat(this.get('price', 0.00)).toFixed(2);
        };

        this.getCommission = function () {
            return parseFloat(this.get('commission', 0.00)).toFixed(2);
        };

        this.valid = function () {
            return this.active() || this.onTrial() || this.onGracePeriod();
        };

        this.onGracePeriod = function () {
            if (this.get('ends_at', false)) {
                return moment().diff(this.get('ends_at')) > 0
            } else {
                return false;
            }
        };

        this.onTrial = function () {
            if (this.get('trial_ends_at', false)) {
                return moment().diff(this.get('trial_ends_at')) > 0
            } else {
                return false;
            }
        };

        this.active = function () {
            return !this.get('ends_at', false) || this.onGracePeriod();
        };
    }
    Subscription.prototype = Object.create(Model.prototype);
    Subscription.prototype.constructor = Subscription;
}());

window.subscriptions = function () {
    return new Subscriptions();
};