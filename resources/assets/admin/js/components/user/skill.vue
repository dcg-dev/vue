<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" v-text="(undefined !== typeof form.slug && form.slug) ? 'Edit ' + form.slug + ' User Skill' : 'Create new User Skill'"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <div v-bind:class="'form-group'+(errors.name ? ' has-error' : '')">
                                <label>Name</label>
                                <input v-model="form.name" type="text" class="form-control">
                                <span class="help-block" v-if="errors.name">
                                    <div v-for="error in errors.name"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                            <div v-if="undefined !== typeof form.slug && form.slug" v-bind:class="'form-group'+(errors.slug ? ' has-error' : '')">
                                <label>Slug</label>
                                <input disabled v-model="form.slug" type="text" class="form-control">
                                <span class="help-block" v-if="errors.slug">
                                    <div v-for="error in errors.slug"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                            <div v-bind:class="'form-group'+(errors.enabled ? ' has-error' : '')">
                                <label>Enabled</label>
                                <input v-model="form.enabled" type="checkbox">
                                <span class="help-block" v-if="errors.enabled">
                                    <div v-for="error in errors.enabled"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="ladda-button btn btn-primary" data-style="expand-right" 
                            v-on:click="submit(undefined !== typeof form.slug && form.slug, $event)">Submit</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['form'],
        watch: {
            'value': function(value) {
                this.$emit('input', value);
            }
        },
        data: function() {
            return {
                errors: []
            };
        },
        mounted: function () {
            var vm = this;
            $(this.$el).on('show.bs.modal, hide.bs.modal', function() {
                vm.errors = [];
            });
        },
        methods: {
            submit: function(isUpdate, event) {
                var button = $(event.target).ladda();
                this.errors = [];
                var vm = this;
                var url =  isUpdate ? '/control/api/skill/'  + this.form.slug + '/update' : '/control/api/skill/create';
                button.ladda('start');
                axios.post(url, this.form).then((response) => {
                    button.ladda('stop');
                    vm.$emit('success', response);
                }, function(error){
                    if(error.response.status == 422) {
                        vm.errors = error.response.data;
                    }
                    vm.$emit('error', error);
                    button.ladda('stop');
                });
            }
        }
    }
</script>
