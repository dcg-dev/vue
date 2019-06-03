<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document" v-if="tag">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" v-text="(!tag.isNew()) ? 'Edit '+tag.get('name')+' Tag' : 'Create new Tag'"></h4>
                </div>
                <div class="modal-body">
                            <div v-bind:class="errors.name ? 'form-group has-error' : 'form-group'">
                                <label>Name</label>
                                <input type="text" class="form-control" v-model="tag.attributes.name">
                                <span class="help-block" v-if="errors.name">
                                    <div v-for="error in errors.name">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                    <div v-bind:class="'form-group'+(errors.slug ? ' has-error' : '')">
                        <label>Slug</label>
                        <input disabled v-model="tag.attributes.slug" type="text" class="form-control">
                        <span class="help-block" v-if="errors.slug">
                            <div v-for="error in errors.slug"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                    <div v-bind:class="errors.enabled ? 'form-group has-error' : 'form-group'">
                        <label>
                            <input type="checkbox" v-model="tag.attributes.enabled">
                            Enabled <small>(This option is responsible for displaying the tag on the site)</small>
                        </label>
                        <span class="help-block" v-if="errors.enabled">
                            <div v-for="error in errors.enabled">
                                <strong v-text="error"></strong>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="ladda-button btn btn-primary" data-style="expand-right" v-on:click="save($event)">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['tag'],
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
            save: function(event) {
                var button = $(event.target).ladda();
                this.errors = [];
                var vm = this;
                button.ladda('start');
                this.tag.save(function(plan){
                    button.ladda('stop');
                    vm.$emit('success', plan);
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
