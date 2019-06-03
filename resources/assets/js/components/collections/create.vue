<template>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">    
        <div class="modal-dialog modal-dialog-popout vertical-align-center">
            <div class="modal-content">
                <div class="block block-themed block-transparent block-rounded remove-margin-b">
                    <div class="block-header bg-white">
                        <ul class="block-options">
                            <li>
                                <button data-dismiss="modal" type="button"><i class="si si-close fa-2x text-gray"></i></button>
                            </li>
                        </ul>
                        <h3 class="font-w600">Create Collection</h3>
                    </div>
                    <div class="block-content">
                        <div class="row" v-if="collection">
                            <div class="col-sm-12 push-20">
                                <div v-bind:class="'form-group'+(errors.name ? ' has-error' : '')">
                                    <input class="form-control" v-model="collection.attributes.name" placeholder="Collection Name" type="text">
                                    <span class="help-block" v-if="errors.name">
                                        <div v-for="error in errors.name"><strong v-text="error"></strong></div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 push-20">
                                <div v-bind:class="'form-group'+(errors.description ? ' has-error' : '')">
                                    <textarea class="form-control" v-model="collection.attributes.description" rows="6" placeholder="Description"></textarea>
                                    <span class="help-block" v-if="errors.description">
                                        <div v-for="error in errors.description"><strong v-text="error"></strong></div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-header">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <button class="btn btn-lg btn-default font-w400" type="button" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button class="btn btn-lg btn-success-modern push-right font-w400" type="button" v-on:click="submit"> Create Collection</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
  export default {
    data: function() {
        return {
            collection: new ItemCollection(),
            errors: [],
        };
    },
    methods: {
        clearForm: function() {
            this.collection = new ItemCollection();
        },
        toggle: function(event) {
            $(this.$el).modal('toggle');
        },
        submit: function() {
            this.errors = [];
            var vm = this;
            this.collection.create(function(collection) {
                vm.clearForm();
                vm.toggle(); 
                vm.errors = [];
                toastr.success("Collection was created successfully.", 'Collection');
                vm.$emit('create', collection);
            }, function(error) {
                if(error.response.status == 422) {
                    vm.errors = error.response.data;
                    toastr.error("Please correct the input data and try again.", 'Collection');
                }
            });
        },
    }
}
</script>