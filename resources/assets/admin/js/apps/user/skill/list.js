if (document.getElementById('admin-user-skill-list')) {
    window.adminUserSkillList = new Vue({
        el: '#admin-user-skill-list',
        data: {
            list: {},
            loading: {
                list: false
            },
            errors: {
                modal: [],
            },
            pagination: {
                total: 0,
                per_page: 16,
                from: 1,
                to: 0,
                current_page: 1
            },
            offset: 16,
            form: null
        },
        mounted: function () {
            this.clearForm();
            this.getList(this.pagination.current_page, this.pagination.per_page);
        },
        methods: {
            clearForm: function () {
                this.form = {
                    name: null,
                    enabled: false,
                    slug: null
                };
            },
            getList: function (page, per_page) {
                this.closeModal();
                if(this.loading.list) {
                    toastr.error('Sorry, the list is currently loading.', 'Skills');
                    return;
                }
                this.loading.list = true;
                axios.get('/control/api/skill/list?page=' + page + '&per_page=' + per_page).then((response) => {
                    if (response.data) {
                        this.list = response.data.data;
                        this.pagination = response.data;
                        this.loading.list = false;
                    }
                }, (error) => {
                    toastr.error('Error has occured during skills obtaining', 'Skills');
                    this.loading.list = false;
                });
            },
            toggleApprove: function (slug, status, event) {
                var currentTD = $(event.currentTarget).parent();
                this.toggleDisableButtons(currentTD);
                axios.post('/control/api/skill/' + slug + '/approving', {enabled: status})
                    .then((response) => {
                        if (response.data) {
                            //update current skill in skills
                            var that = this;
                            _.each(that.list, function(skill, key) {
                                if (skill.id == response.data.id) {
                                    Vue.set(that.list[key], 'enabled', response.data.enabled);
                                    return;
                                }
                            });
                        }
                        toastr.info('Skill approving status has been changed successfully!', 'Skills');
                        this.toggleDisableButtons(currentTD);
                    }, (error) => {
                        toastr.error('Skill has occured during skill approving.', 'Skills');
                        this.toggleDisableButtons(currentTD);
                    });
            },
            toggleDisableButtons: function (currentTD) {
                currentTD.find('button').prop('disabled', function(i, v) { return !v; });
            },
            deleteSkill: function (slug, event) {
                var currentTD = $(event.currentTarget).parent();
                this.toggleDisableButtons(currentTD);
                axios.delete('/control/api/skill/' + slug).then((response) => {
                    if (response.data.status) {
                        toastr.info('Skill has been deleted successfully!', 'Skills');
                        this.toggleDisableButtons(currentTD);
                        var that = this;
                        _.each(that.list, function(skill, key) {
                            if (skill.slug == slug) {
                                Vue.delete(that.list, key);
                                return;
                            }
                        });
                    } else {
                        this.toggleDisableButtons(currentTD);
                        toastr.error('Error has occured during skill deleting. Try again.', 'Skills');
                    }
                }, (error) => {
                    toastr.error('Error has occured during skill deleting. Try again.', 'Skills');
                    this.toggleDisableButtons(currentTD);
                });
            },
            newSkill: function() {
                this.clearForm();
                $('#user-skill-modal').modal('show');
            },
            editSkill: function(skill) {
                this.form = skill;
                $('#user-skill-modal').modal('show');
            },
            closeModal: function() {
                $('#user-skill-modal').modal('hide');
            }
        },
        filters: {
            moment: function (date) {
                return moment.unix(date).format('HH:mm:ss DD-MM-YYYY');
            }
        }
    });
}