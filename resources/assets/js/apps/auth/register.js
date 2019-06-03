if (document.getElementById('register-page')) {
    window.register = new Vue({
        el: '#register-page',
        data: {
            button: false,
            successShow: false,
            form: {
                firstname: null,
                lastname: null,
                email: null,
                password: null,
                password_confirmation: null,
                accepted: false,
            },
            errors: []
        },
        methods: {
            submit: function (event) {
                this.errors = [];
                axios.post('/register', this.form).then((response) => {
                    if (response.data) {
                        this.successShow = true;
                        this.form = {
                            firstname: null,
                            lastname: null,
                            email: null,
                            password: null,
                            password_confirmation: null,
                            accepted: false,
                        };
                    }
                }, (error) => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data;
                    }
                });
            },
        },
    });
    document.getElementById('termsAccepted').addEventListener("click", function () {
        register.form.accepted = true;
    });
}