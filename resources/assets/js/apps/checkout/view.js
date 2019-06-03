if (document.getElementById('checkout-view')) {
    window.checkoutView = new Vue({
        el: '#checkout-view',
        data: {
            currentUser: false,
            successShow: false,
            cart: null,
            button: false,
            form: {
                username: null,
                email: null,
                firstname: null,
                lastname: null,
                city: null,
                country: null,
                password: null,
                password_confirmation: null,
                card_name: null,
                card_brand: null,
                card_last_four: null,
                token: null,
                payment_type: 'paypal',
                edit_mode: false
            },
            errors: {},
        },
        mounted: function () {
            this.currentUser = currentUser;
            if (this.currentUser) {
                this.form.card_name = currentUser.get('card_name');
                this.form.card_brand = currentUser.get('card_brand');
                this.form.card_last_four = currentUser.get('card_last_four');
            }
            this.cart = cart;
        },
        methods: {
            removeItemFromCart: function (itemId) {
                var self = this;
                if (itemId) {
                    checkoutView.cart.removeFromCart(itemId, function () {
                        self.successShow = true;
                        setTimeout(() => {
                            self.successShow = false;
                            setTimeout(() => {
                                checkoutView.cart.getCartInfo(function (info) {
                                    checkoutView.info = info;
                                });
                            }, 1000);
                        }, 1500);
                    }, function () {
                        toastr.error("Error happened during removing the item from cart", "Cart");
                    });
                }
            },
            choosePayment: function (paymentType) {
                $("a.block-link-hover2 div.block-content").toggleClass("bg-gray-light");
                this.form.payment_type = paymentType;
            },
            changeToken: function (token) {
                this.form.token = token;
            },
            completeOrder: function (event) {
                users().current(function (user) {
                    if (!user.get('firstname') || !user.get('lastname') || !user.get('country')) {
                        swal({
                                title: "Profile",
                                text: "In order to complete the purchase process, you need to fill out your profile!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonText: "I want to do this now",
                                cancelButtonText: "I'll do it later",
                                closeOnConfirm: true
                            },
                            function () {
                                location.href = '/profile/settings';
                            });
                        return false;
                    }
                    var button = event.target;
                    button.disabled = true;
                    checkoutView.errors = [];
                    checkoutView.cart.submitCheckout(checkoutView.form, function (response) {
                        if (checkoutView.form.payment_type == 'stripe') {
                            toastr.info("Order has been completed successfully!", 'Cart');
                            window.location.replace('/profile/downloads');
                        } else {
                            window.location.replace(response.data.url);
                        }

                    }, function (error) {
                        button.disabled = false;
                        if (error.response.status == 422) {
                            checkoutView.errors = error.response.data;
                            toastr.error("Please correct the input data and try again.", 'Cart');
                        }
                    });
                }, function () {
                    location.href = '/login';
                });
            }
        },
    });
}