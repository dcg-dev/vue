if (document.getElementById('login-page')) {
    window.login = new Vue({
        el: '#login-page',
        data: {
            button: false,
            form: {
                email: null,
                password: null,
                remember: false,
            },
            errors: []
        },
        methods: {
            submit: function (event) {
                this.errors = [];
                axios.post('/login', this.form).then((response) => {
                    if (response.data) {
                        location.href = '/';
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