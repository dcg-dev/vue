if (document.getElementById('checkout-cart-icon')) {
    window.checkoutCartIcon = new Vue({
        el: '#checkout-cart-icon',
        data: {
            currentUser: false,
            cart: null
        },
        mounted: function () {
            this.currentUser = currentUser;
            this.cart = cart;
        },
    });
}