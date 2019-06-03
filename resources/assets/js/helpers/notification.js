(function () {
    this.Notify = function () {

        this.info = function (message, title) {
            swal({
                title: title,
                text: message,
                type: 'info',
                showCancelButton: false,
                closeOnConfirm: true
            });
        }

        this.success = function (message, title) {
            swal({
                title: title,
                text: message,
                type: 'success',
                showCancelButton: false,
                closeOnConfirm: true
            });
        }

        this.error = function (message, title) {
            swal({
                title: title,
                text: message,
                type: 'error',
                showCancelButton: false,
                closeOnConfirm: true
            });
        }

        this.guest = function (message) {
            swal({
                title: "You’re a guest.",
                text: message,
                type: 'info',
                confirmButtonColor: "#88c5e0",
                confirmButtonText: "Sign in!",
                showCancelButton: true,
            }, function () {
                location.href = "/login";
            });
        }
    }
}());

window.notify = new Notify();
