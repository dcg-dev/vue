(function () {
    Tags.prototype.all = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/control/api/tag/list'+params, success, error);
    }
    Tag.prototype.save = function(success, error) {
        var actions = this.isNew() ? 'create' : this.get('slug')+'/update';
        axios.post('/control/api/tag/'+actions, this.getAttributes()).then((response) => {
            if (response.data) {
                this.setAttributes(response.data);
                if(success && typeof success === "function") {
                        success(this, response);
                    }
                }
        }, (response) => {
            if(error && typeof error === "function") {
                error(response);
            }
        });
    }
    Tag.prototype.delete = function(success, error) {
        axios.post('/control/api/tag/'+this.get('slug')+'/delete').then((response) => {
            if (response.data) {
                if(success && typeof success === "function") {
                        success(response);
                    }
                }
        }, (response) => {
            if(error && typeof error === "function") {
                error(response);
            }
        });
    }
}());