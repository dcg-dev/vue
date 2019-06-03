(function () {
    this.Users = function () {
        Collection.call(this);
    }
    Users.prototype = Object.create(Collection.prototype);
    Users.prototype.constructor = Users;
    Users.prototype.model = function (attributes) {
        return new User(attributes);
    }
    Users.prototype.all = function (success, error, params) {
        params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
        this.list('/api/user/list' + params, success, error);
    }

    Users.prototype.current = function (success, error, redirect) {
        params =  '?' + queryString.stringify({
            'relations': [
                'subscriptions'
            ]
        }, {arrayFormat: 'index'});
        axios.get('/api/user/current'+params).then((response) => {
            if (!response.data || !response.data.status) {
                if (redirect && currentUser) {
                    location.reload();
                }
                if (error) {
                    error(response);
                }
            } else {
                if (redirect && !currentUser) {
                    location.reload();
                }
                if (success) {
                    success(new User(response.data.user));
                }
            }
        }, (response) => {
            if (redirect && currentUser) {
                location.reload();
            }
            if (error) {
                error(response);
            }
        });
    }
}());

(function () {
    this.User = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
            'favourites': function (data) {
                return (new Favourites()).setResponse({
                    data: data
                });
            },
            'followers': function (data) {
                return (new Users()).setResponse({
                    data: data
                });
            },
            'following': function (data) {
                return (new Users()).setResponse({
                    data: data
                });
            },
            'friends': function (data) {
                return (new Users()).setResponse({
                    data: data
                });
            },
            'feed': function (data) {
                return (new Items()).setResponse({
                    data: data
                });
            },
            'ratings': function (data) {
                return (new Ratings()).setResponse({
                    data: data
                });
            },
            'notifications': function (data) {
                return (new Notifications()).setResponse({
                    data: data
                });
            },
            'subscriptions': function (data) {
                return (new Subscriptions()).setResponse({
                    data: data
                });
            },
            'country_info' : function(attributes) {
                return new Country(attributes);
            },
        };

        this.oldAttributes = {};

        this.setAttributes(attributes);

        this.getFullname = function () {
            return this.get('username');
            if (!this.get('firstname', false) && !this.get('lastname', false)) {
                return this.get('username');
            }
            return this.get('firstname') + " " + this.get('lastname');
        };

        this.getAvatar = function () {
            return this.get('avatar');
        };

        this.getUrl = function () {
            return "/user/" + this.get('username');
        };

        this.checkSellerProfile = function () {
            return this.get('firstname') && this.get('lastname') && this.get('country') && this.get('paypal_email')
                && this.get('address_1') && this.get('city') && this.get('state');
        };

        this.feed = function (success, error, params) {
            if (!currentUser || this.get('id') !== currentUser.get('id')) {
                console.error('You not have permission to access this user feed.');
                return false;
            }
            params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
            axios.get('/api/user/feed' + params).then((response) => {
                if (response.data) {
                    this.set('feed', (new Items()).setResponse(response));
                    if (success && typeof success === "function") {
                        success(this.get('feed'), response);
                    }
                }
            }, (response) => {
                this.set('feed', new Items());
                if (error && typeof error === "function") {
                    error(response);
                }
            });
        }

        this.feedCount = function (success, error, params) {
            if (!currentUser || this.get('id') !== currentUser.get('id')) {
                console.error('You do not have permission to access this user feed.');
                return false;
            }
            params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
            axios.get('/api/user/feed/count' + params).then((response) => {
                if (success && typeof success === "function") {
                    success(response.data ? response.data : 0, response);
                }
            }, (response) => {
                if (error && typeof error === "function") {
                    error(response);
                }
            });
        }

        this.iFollow = function () {
            return this.get('iFollow') ? true : false;
        };

        this.followers = function (success, error, params) {
            params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
            axios.get('/api/user/' + this.get('username') + '/followers' + params).then((response) => {
                if (response.data) {
                    this.set('followers', (new Users()).setResponse(response));
                    if (success && typeof success === "function") {
                        success(this.get('followers'), response);
                    }
                }
            }, (response) => {
                this.set('followers', new Users());
                if (error && typeof error === "function") {
                    error(response);
                }
            });
        };

        this.following = function (success, error, params) {
            params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
            axios.get('/api/user/' + this.get('username') + '/following' + params).then((response) => {
                if (response.data) {
                    this.set('following', (new Users()).setResponse(response));
                    if (success && typeof success === "function") {
                        success(this.get('following'), response);
                    }
                }
            }, (response) => {
                this.set('following', new Users());
                if (error && typeof error === "function") {
                    error(response);
                }
            });
        };

        this.follow = function (success, error) {
            axios.post('/api/user/' + this.get('username') + '/follow/toggle').then((response) => {
                if (response.data) {
                    this.setAttributes(response.data);
                    if (success && typeof success === "function") {
                        success(this, response);
                    }
                }
            }, (response) => {
                if (error && typeof error === "function") {
                    error(response);
                }
            });
        };


        this.friends = function (success, error, params) {
            params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
            axios.get('/api/user/friends' + params).then((response) => {
                if (response.data) {
                    this.set('friends', (new Users()).setResponse(response));
                    if (success && typeof success === "function") {
                        success(this.get('friends'), response);
                    }
                }
            }, (response) => {
                this.set('friends', new Users());
                if (error && typeof error === "function") {
                    error(response);
                }
            });
        };

        this.favourites = function (success, error, params) {
            params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
            axios.get('/api/user/favourites' + params).then((response) => {
                if (response.data) {
                    this.set('favourites', (new Favourites()).setResponse(response));
                    if (success && typeof success === "function") {
                        success(this.get('favourites'), response);
                    }
                }
            }, (response) => {
                this.set('favourites', new Favourites());
                if (error && typeof error === "function") {
                    error(response);
                }
            });
        };

        this.notifications = function (success, error, params) {
            params = params ? '?' + queryString.stringify(params, {arrayFormat: 'index'}) : '';
            axios.get('/api/profile/notifications' + params).then((response) => {
                if (response.data) {
                    this.set('notifications', (new Notifications()).setResponse(response));
                    if (success && typeof success === "function") {
                        success(this.get('notifications'), response);
                    }
                }
            }, (response) => {
                this.set('notifications', new Notifications());
                if (error && typeof error === "Notifications") {
                    error(response);
                }
            });
        };

        this.flushNotifications = function (success, error) {
            axios.post('/api/profile/flushNotifications').then((response) => {
                toastr.info('Notifications have been flushed!');
                location.reload();
            }, (response) => {
                if (error) {
                    error(response);
                }
            });
        }

        this.generateAffilateLink = function(url, success, error) {
            var separator = url.indexOf('?') > -1 ? '&' : '?';
            return url + separator + 'ref=' + this.get('username');
        }

        this.makeAffiliateRequest = function(params, success, error) {
            axios.post('/api/affiliate/request', params).then((response) => {
                if (response.data) {
                    if (success && typeof success === "function") {
                        success(response);
                    }
                }
            }, (response) => {
                if (error) {
                    error(response);
                }
            });
        }

        this.subscribed = function(plan) {
            if(!this.get('subscriptions') || this.get('subscriptions').isEmpty()) {
                return false;
            }
            var subscription = this.get('subscriptions').find(plan, 'stripe_plan');
            if(!subscription || !subscription.valid()) {
                return false;
            }
            return true;
        }

        this.getActivePlan = function (name) {
            var subscriptions = this.get('subscriptions');
            if(!subscriptions.isEmpty()) {
                for(var index in subscriptions.getData()) {
                    var subscription = subscriptions.index(index);
                    if((!name || subscription.name == name) && subscription.valid()) {
                        return subscription;
                    }
                }
            }
            return false;
        }

        this.isAdmin = function() {
            return this.get('role') == 'admin';
        }

        this.canUsePro = function() {
            var proLevel = 3;
            return this.isAdmin() || this.get('level') >= proLevel;
        }


        this.renewalSubscription = function(renewal, success, error) {
            axios.post('/api/billing/renewal-subscription', {renewal: renewal}).then((response) => {
                if (response.data) {
                    if (success && typeof success === "function") {
                        success(response);
                    }
                }
            }, (response) => {
                if (error) {
                    error(response);
                }
            });
        }

        this.getDashboard = function (success, error) {
            axios.get('/api/profile/dashboard').then((response) => {
                if (response.data) {
                    if (success && typeof success === "function") {
                        success(response);
                    }
                }
            }, (response) => {
                error(response);
            });
        };

        this.getStatistics = function (type, success, error) {
            axios.get('/api/profile/statistics/' + type).then((response) => {
                if (response.data) {
                    if (success && typeof success === "function") {
                        success(response);
                    }
                }
            }, (response) => {
                error(response);
            });
        };

    }
    User.prototype = Object.create(Model.prototype);
    User.prototype.constructor = User;
}());

window.users = function () {
    return new Users();
};