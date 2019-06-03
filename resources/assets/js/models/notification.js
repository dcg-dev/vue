(function () {
    this.Notifications = function () {
        Collection.call(this);
    }
    Notifications.prototype = Object.create(Collection.prototype);
    Notifications.prototype.constructor = Notifications;
    Notifications.prototype.model = function(attributes) {
        return new Notification(attributes);
    }
}());

(function () { 
    this.Notification = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.dates = [
            'created_at', 'updated_at'
        ];
        this.relations = {
        };
        this.oldAttributes = {};
        this.setAttributes(attributes);
        
        this.getType = function () {
            //remove packages
            return this.get('type').replace(/App\\Notifications\\/,""); 
        };
        
        //get all information about notification
        this.getInfo = function () {
            var info = {
                icon: null,
                color: null,
                text: null,
                url: null,
                urlText: null
            };

            switch(this.getType()) {
                case 'StoryReleased':
                    info.icon = 'plus';
                    info.color = 'success';
                    info.text = 'Story released';
                    info.url = '/blog/story/' + (typeof this.get('data').slug !== 'undefined' ? this.get('data').slug : '');
                    info.urlText = typeof this.get('data').name !== 'undefined' ? this.get('data').name : '';
                    break;
                case 'ItemFollowerReleased':
                    info.icon = 'plus';
                    info.color = 'success';
                    info.text = this.get('data').username+' has released new item';
                    info.url = '/item/' + (typeof this.get('data').slug !== 'undefined' ? this.get('data').slug : '');
                    info.urlText = typeof this.get('data').name !== 'undefined' ? this.get('data').name : '';
                    break;
                case 'ItemReleased':
                    info.icon = 'plus';
                    info.color = 'success';
                    info.text = 'Item released';
                    info.url = '/item/' + (typeof this.get('data').slug !== 'undefined' ? this.get('data').slug : '');
                    info.urlText = typeof this.get('data').name !== 'undefined' ? this.get('data').name : '';
                    break;
                case 'ItemDeleted':
                    info.icon = 'close';
                    info.color = 'danger';
                    info.text = 'Item deleted';
                    info.url = '/profile/items';
                    info.urlText = typeof this.get('data').name !== 'undefined' ? this.get('data').name : '';
                    break;
                case 'ItemDeclined':
                    info.icon = 'close';
                    info.color = 'warning';
                    info.text = 'Item declined';
                    info.subText = typeof this.get('data').decline_reason !== 'undefined' ? this.get('data').decline_reason : '';
                    info.url = '/profile/items';
                    info.urlText = typeof this.get('data').name !== 'undefined' ? this.get('data').name : '';
                    break;
                case 'NewItemReview':
                    info.icon = 'star';
                    info.color = 'success';
                    info.text = 'New review';
                    info.url = '/item/' + (typeof this.get('data').slug !== 'undefined' ? this.get('data').slug : '');
                    info.urlText = typeof this.get('data').name !== 'undefined' ? this.get('data').name : '';
                    break;
                case 'NewItemComment':
                    info.icon = 'pencil';
                    info.color = 'info';
                    info.text = 'New comment';
                    info.url = '/item/' + (typeof this.get('data').slug !== 'undefined' ? this.get('data').slug : '');
                    info.urlText = typeof this.get('data').name !== 'undefined' ? this.get('data').name : '';
                    break;
                case 'NewPurchase':
                    info.icon = 'cloud-download';
                    info.color = 'success';
                    info.text = 'New Purchase ($' + (typeof this.get('data').price !== 'undefined' ? this.get('data').price : '') + ')';
                    info.url = '/profile/downloads';
                    info.urlText = typeof this.get('data').name !== 'undefined' ? this.get('data').name + ' - Download' : '';
                    break;
                case 'NewSale':
                    info.icon = 'wallet';
                    info.color = 'success';
                    info.text = 'New Sale ($' + (typeof this.get('data').price !== 'undefined' ? this.get('data').price : '') + ')';
                    info.url = '/profile/sales';
                    info.urlText = typeof this.get('data').name !== 'undefined' ? this.get('data').name : '';
                    break;
                case 'PurchasedItemUpdated':
                    info.icon = 'wrench';
                    info.color = 'info';
                    info.text = 'Purchased item has been updated';
                    info.url = '/item/' + (typeof this.get('data').slug !== 'undefined' ? this.get('data').slug : '');
                    info.urlText = typeof this.get('data').name !== 'undefined' ? this.get('data').name : '';
                    break;
                case 'NewMessage':
                    info.icon = 'envelope-letter';
                    info.color = 'success';
                    info.text = 'New message';
                    info.url = '/profile/inbox';
                    info.urlText = 'You have new message';
                    break;
            }
            return info; 
        };
    }
    Notification.prototype = Object.create(Model.prototype);
    Notification.prototype.constructor = Notification;
}());

window.notifications = function () {
    return new Notifications();
};