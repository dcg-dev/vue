axios.interceptors.response.use(null, function (error) {
    if (error.response.status != 422) {
        // toastr.error(error.response.data.message, error.response.statusText);
    }
    if (error.response.data.exception && error.response.data.exception == "Illuminate\Session\TokenMismatchException") {
        toastr.error("Your session has expired or you are logged out. You will be redirected to the authorization page", "Session");
        location.href = '/login';
    }
    return Promise.reject(error);
});

(function () {
    this.Route = function () {

    }
    Route.prototype.redirect = function (url, method) {
        var form = document.createElement('form');
        form.method = method;
        form.action = url;
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "_token";
        input.value = Laravel.csrfToken;
        form.appendChild(input);
        document.body.appendChild(form).submit();
    }
}());

window.route = function (url) {
    return new Route(url);
};