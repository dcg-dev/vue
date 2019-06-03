if (document.getElementById('reset-email-page')) {
    window.resetEmail = new Vue({
        el: '#reset-email-page',
        data: {
            successShow: false,
            button: false,
            form: {
                email: null,
            },
            errors: []
        },
        methods: {
            submit: function (event) {
                this.errors = [];
                axios.post('/password/email', this.form).then((response) => {
                    if (response.data) {
                        this.successShow = true;
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