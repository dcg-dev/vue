<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document"  v-if="topic">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" v-text="(!topic.isNew()) ? 'Edit ' + topic.get('question') + ' FAQ Topic' : 'Create new FAQ Topic'"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <div v-bind:class="'form-group'+(errors.question ? ' has-error' : '')">
                                <label>Question*</label>
                                <input v-model="topic.attributes.question" type="text" class="form-control">
                                <span class="help-block" v-if="errors.question">
                                    <div v-for="error in errors.question"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                            <div v-bind:class="'form-group'+(errors.answer ? ' has-error' : '')">
                                <label>Answer*</label>
                                <textarea v-model="topic.attributes.answer" type="text" class="form-control"></textarea>
                                <span class="help-block" v-if="errors.answer">
                                    <div v-for="error in errors.answer"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                            <div v-bind:class="'form-group'+(errors.faq_category_id ? ' has-error' : '')">
                                <label>FAQ Category*</label>
                                <select v-if="!categories.isEmpty()" class="form-control" v-model="topic.attributes.faq_category_id">
                                    <option v-for="category in categories.getData()" 
                                            v-bind:value="category.attributes.id"
                                            v-text="category.attributes.name" 
                                            v-bind:selected="topic.attributes.faq_category_id == category.attributes.id">
                                    </option>
                                </select>
                                <span v-else>Create FAQ Category before creating FAQ Topic</span>
                                <span class="help-block" v-if="errors.faq_category_id">
                                    <div v-for="error in errors.faq_category_id"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                            <div v-bind:class="'form-group'+(errors.types ? ' has-error' : '')">
                                <label>Types</label>
                                <select class="form-control" multiple="true" v-model="topic.attributes.types">
                                    <option v-bind:value="'account'" v-bind:selected="topic.attributes.types == 'account'">account</option>
                                    <option v-bind:value="'features'" v-bind:selected="topic.attributes.types == 'admin'">features</option>
                                    <option v-bind:value="'services'" v-bind:selected="topic.attributes.types == 'services'">services</option>
                                    <option v-bind:value="'payment'" v-bind:selected="topic.attributes.types == 'payment'">payment</option>
                                </select>
                                <span class="help-block" v-if="errors.types">
                                    <div v-for="error in errors.types"><strong v-text="error"></strong></div>
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
        props: ['topic', 'categories'],
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
                var url = this.topic.isNew() ? '/control/api/support/faq/topic/create' : '/control/api/support/faq/topic/' + this.topic.attributes.id + '/update';
                button.ladda('start');
                axios.post(url, this.topic.attributes).then((response) => {
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
