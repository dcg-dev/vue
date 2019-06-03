if (document.getElementById('item-view')) {
    window.itemView = new Vue({
        el: '#item-view',
        data: {
            id: null,
            item: false,
            license: null,
            button: null,
            loading: true,
            releated: new Items(),
        },
        computed: {
            currentUser: function () {
                return currentUser;
            },
            cart: function () {
                return cart;
            }
        },
        mounted: function () {
            this.id = this.$el.dataset.id;
            this.get();
        },
        methods: {
            get: function () {
                this.loading = true;
                items().get('/api/item/' + this.id, function (item) {
                    itemView.item = item;
                    itemView.item.comments(null, null, {
                        'order': [
                            'created_at|desc'
                        ]
                    });
                    itemView.item.ratings();
                    itemView.license = itemView.item.get('licenses').first();
                    itemView.loading = false;
                    itemView.loadReleated();
                }, function () {
                    itemView.loading = false;
                }, {
                    'relations': [
                        'creator',
                        'tags',
                        'formats',
                        'licenses'
                    ]
                });
            },
            loadReleated: function () {
                var self = this;
                axios.get('/api/user/' + this.item.get('creator').get('username') + '/items?per_page=50&noids=' + this.item.get('id')).then(function (response) {
                    self.releated = new Items().setResponse(response);
                    self.$nextTick(function () {
                        $('.releated-items').slick({
                            dots: true,
                            infinite: true,
                            speed: 300,
                            slidesToShow: 4,
                            slidesToScroll: 4,
                            responsive: [
                                {
                                    breakpoint: 1024,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 3,
                                        infinite: true,
                                        dots: true
                                    }
                                },
                                {
                                    breakpoint: 600,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 2
                                    }
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1
                                    }
                                }
                                // You can unslick at a given breakpoint now by adding:
                                // settings: "unslick"
                                // instead of a settings object
                            ]
                        });
                    });
                });
            },
            tabShow: function (event) {
                $(event.target).tab('show');
            },
            like: function (comment) {
                comment.like();
            },
            commentPage: function (page) {
                this.item.comments(null, null, {
                    'page': page
                });
            },
            share: function (provider) {
                switch (provider) {
                    case 'facebook':
                        social().facebook().share();
                        break;
                    case 'twitter':
                        social().twitter().share(
                            false,
                            window.currentUser && window.currentUser.get('id') == this.item.get('creator').get('id') ?
                                'Hi there! Check out my latest track "' + this.item.get('name') + '" at ' + location.host :
                                'Hi there! Check out this awesome track "' + this.item.get('name') + '" at ' + location.host,
                            'roqstar,' + window.currentUser.get('username')
                        );
                        break;
                }
            },
            setLicense: function (license) {
                this.license = license;
            },
            attach: function () {
                $('#collection-attach').modal('toggle');
            },
            guestMessage: function () {
                notify.guest("Please login to commit this action.");
            },
            addItemToCart: function (event) {
                var that = this;
                if (that.license) {
                    that.cart.addToCart(that.license.get('pivot').item_id, that.license.get('id'), function (cart) {
                        swal({
                            title: "Added to cart!",
                            text: "Do you want to checkout?",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonText: "Go to Checkout",
                            cancelButtonText: "Continue Shopping",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        }, function () {
                            location.href = "/checkout";
                        });
                        that.cart.getCartInfo(function (info) {
                            window.cart.info = info;
                        });
                        that.get();
                    }, function (error) {
                        toastr.error(error, "Item");
                    });
                } else {
                    toastr.error("You didn't choose any license", "Item");
                }
            },
        },
    });
}