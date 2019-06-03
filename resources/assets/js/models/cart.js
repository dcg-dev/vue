(function () {
    this.Cart = function () {
        this.info = {
            items: [],
            subtotal: null,
            total: null
        };
        
        this.getCartInfo = function (success, error) {
            axios.get('/api/checkout/info').then((response) => {
                if (response.data) {
                    success(response.data);
                    this.info = response.data;
                    _.each(this.info.items, function(item) {
                        item.attributes = new Item(item.attributes);
                    });
                }
            }, (response) => {
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };
        
        this.addToCart = function (itemId, licenseId, success, error) {
            axios.post('/api/checkout/item/add', {itemId: itemId, licenseId: licenseId}).then((response) => {
                if(response.data.status) {
                    if(success && typeof success === "function") { 
                        success(response);
                    }
                } else {
                    if(error && typeof error === "function") {
                        error(response);
                    }
                }
            }, (response) => {
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };
        
        this.removeFromCart = function (itemId, success, error) {
            axios.delete('/api/checkout/item/' + itemId).then((response) => {
                if(response.data.status) {
                    if(success && typeof success === "function") { 
                        success(response);
                    }
                } else {
                    if(error && typeof error === "function") {
                        error(response);
                    }
                }
            }, (response) => {
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };
        
        this.submitCheckout = function (form, success, error) {
            axios.post('/api/checkout/complete', form).then((response) => {
                if(response.data.status) {
                    if(success && typeof success === "function") { 
                        success(response);
                    }
                } else {
                    if(error && typeof error === "function") {
                        error(response);
                    }
                }
            }, (response) => {
                if(error && typeof error === "function") {
                    error(response);
                }
            });
        };
    }
}());

window.cart = new Cart();

