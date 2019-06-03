(function () {
    FaqTopic.prototype.getEditUrl = function(type) {
        return '/control/support/faq/topic/' + this.get('id') + '/edit';
    }
    FaqTopic.prototype.delete = function(success, error) {
        axios.delete('/control/api/support/faq/topic/' + this.get('id')).then((response) => {
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