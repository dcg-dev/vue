(function () {
    Skills.prototype.all = function(success, error, params) {
        params = params ? '?'+queryString.stringify(params,{arrayFormat: 'index'}) : '';
        this.list('/control/api/skill/list'+params, success, error);
    }
    Skill.prototype.save = function(success, error) {
        var actions = this.isNew() ? 'create' : this.get('slug')+'/update';
        axios.post('/control/api/skill/'+actions, this.getAttributes()).then((response) => {
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
    Skill.prototype.delete = function(success, error) {
        axios.delete('/control/api/skill/'+this.get('slug')).then((response) => {
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