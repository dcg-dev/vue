<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document"  v-if="category">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" v-text="(!category.isNew()) ? 'Edit ' + category.get('name') + ' FAQ Category' : 'Create new FAQ Category'"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <div v-bind:class="'form-group'+(errors.name ? ' has-error' : '')">
                                <label>Name*</label>
                                <input v-model="category.attributes.name" type="text" class="form-control">
                                <span class="help-block" v-if="errors.name">
                                    <div v-for="error in errors.name"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="ladda-button btn btn-primary" data-style="expand-right" v-on:click="submit($event)">Submit</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['category'],
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
            submit: function(event) {
                var button = $(event.target).ladda();
                this.errors = [];
                var vm = this;
                var url = this.category.isNew() ? '/control/api/support/faq/category/create' : '/control/api/support/faq/category/' + this.category.attributes.id + '/update';
                button.ladda('start');
                axios.post(url, this.category.attributes).then((response) => {
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
