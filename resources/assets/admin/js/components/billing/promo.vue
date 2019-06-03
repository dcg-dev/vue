<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document" v-if="plan">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" v-text="(!plan.isNew()) ? 'Edit '+plan.get('name')+' Promotional Plan' : 'Create new Promotional Plan'"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div v-bind:class="errors.name ? 'form-group has-error' : 'form-group'">
                                <label>Name</label>
                                <input type="text" class="form-control" v-model="plan.attributes.name">
                                <span class="help-block" v-if="errors.name">
                                    <div v-for="error in errors.name">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                      </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div v-bind:class="errors.price ? 'form-group has-error' : 'form-group'">
                                <label>Price</label>
                                <input type="number" class="form-control" v-model="plan.attributes.price">
                                <span class="help-block" v-if="errors.price">
                                    <div v-for="error in errors.price">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Duration</label>
                                <div class="row">
                                    <div class="col-md-8" v-bind:class="{'has-error': errors.duration}">
                                        <input type="number" class="form-control" v-model="plan.attributes.duration">
                                        <span class="help-block" v-if="errors.duration">
                                            <div v-for="error in errors.duration">
                                                <strong v-text="error"></strong>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="col-md-4" v-bind:class="{'has-error': errors.duration_type}">
                                        <select class="form-control" v-model="plan.attributes.duration_type">
                                            <option value="hour" selected="true">hours</option>
                                            <option value="day">days</option>
                                        </select>
                                        <span class="help-block" v-if="errors.duration_type">
                                            <div v-for="error in errors.duration_type">
                                                <strong v-text="error"></strong>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div v-bind:class="errors.enabled ? 'form-group has-error' : 'form-group'">
                        <label>
                            <input type="checkbox" v-model="plan.attributes.enabled">
                            Enabled <small>(This option is responsible for displaying the plan on the site)</small>
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
        props: ['plan'],
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
                this.plan.save(function(plan){
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
