if (document.getElementById('reset-password-page')) {
    window.resetEmail = new Vue({
        el: '#reset-password-page',
        data: {
            button: false,
            successShow: false,
            form: {
                token: null,
                email: null,
                password: null,
                password_confirmation: null,
            },
            errors: []
        },
        mounted: function () {
            var path = location.pathname.split('/');
            this.form.token = path[path.length - 1];
        },
        methods: {
            submit: function (event) {
                this.errors = [];
                axios.post('/password/reset', this.form).then((response) => {
                    if (response.data) {
                        this.successShow = true;
                        setTimeout(() => {
                            location.href = "/";
                        }, 2000);
                    }
                }, (error) => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data;
                    }
                });
            },
        },
    });
}