(function () {
    FaqCategory.prototype.getEditUrl = function(type) {
        return '/control/support/faq/category/' + this.get('id') + '/edit';
    }
    FaqCategory.prototype.delete = function(success, error) {
        axios.delete('/control/api/support/faq/category/' + this.get('id')).then((response) => {
            if (response.data) {
                if(response.data.status) {
                    if(success && typeof success === "function") { 
                        success(response);
                    }
                } else {
                    if(error && typeof error === "function") {
                        error(response);
                    }
                }
            }
        }, (response) => {
            if(error && typeof error === "function") {
                error(response);
            }
        });
    }
}());