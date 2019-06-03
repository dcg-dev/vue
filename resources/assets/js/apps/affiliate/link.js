if (document.getElementById('affiliate-link')) {
    window.affiliateLink = new Vue({
        el: '#affiliate-link',
        data: {
            errors: {
                link: '',
                accept: '',
            },
            currentUser: false,
            generatedLink: null
        },
        mounted: function () {
            this.currentUser = currentUser;
            this.currentUser ? this.currentUser.attributes.accepted = false : null;
            this.currentUser ? this.currentUser.attributes.affiliate_link = null : null;
        },
        methods: {
            generateLink: function () {
                this.errors.link = "";
                var self = this;
                if (this.currentUser.get('accepted')) {
                    if (this.currentUser.get('affiliate_link') && new UrlHelper(this.currentUser.get('affiliate_link')).checkHostUrl()) {
                        var promise = axios.post('/api/item/affilate', {
                            link: this.currentUser.get('affiliate_link')
                        });
                        promise.then(function (response) {
                            self.generatedLink = response.data;
                        });
                        promise.catch(function (error) {
                            self.errors.link = error.response.data;
                        });
                    } else {
                        this.errors.link = 'Item link is invalid, probabaly it\'s neither url, or from this site';
                    }
                } else {
                    this.errors.accept = 'You must agree to the terms & conditions before generating link', 'Referral Links';
                }
            },
            copyToClipboard: function () {
                var urlField = document.querySelector('#clipboard-input');
                // select the contents
                urlField.select();
                document.execCommand('copy');
                toastr.info('Generated url has been copied successfully!', 'Referral Links');
            }
        },
    });
}