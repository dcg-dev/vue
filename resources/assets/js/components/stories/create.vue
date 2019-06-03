<template>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-popout">
        <div class="modal-content">
            <div class="block block-themed block-transparent block-rounded remove-margin-b">
                <div class="block-header bg-white">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close fa-2x text-gray"></i></button>
                        </li>
                    </ul>
                    <h3 class="font-w600">Create Blog Story</h3>
                </div>
                <div class="block-content">
                    <div class="row" v-if="story">
                        <div class="col-sm-12 push-20">
                            <label>Title</label>
                            <div v-bind:class="'form-group' + (errors.title ? ' has-error' : '')">
                                <input class="form-control" v-model="story.attributes.title" placeholder="Story Title" type="text">
                                <span class="help-block" v-if="errors.title">
                                    <div v-for="error in errors.title"><strong v-text="error"></strong></div>
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
                            <button class="btn btn-lg btn-success-modern push-right font-w400" type="button" data-style="expand-right" v-on:click="submit($event)">Create Story</button>
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
    data: function () {
        return {
            story: new Story(),
            errors: [],
            button: null,
        };
    },
    methods: {
        clearForm: function () {
            this.story = new Story();
        },
        toggle: function (event) {
            $(this.$el).modal('toggle');
        },
        submit: function (event) {
            this.errors = [];
            var vm = this;
            this.story.create(function(newStory) {
                vm.clearForm();
                vm.toggle(); 
                vm.errors = [];
                toastr.success("Blog Story has been created successfully.", 'Story');
                window.location.replace(newStory.getPublishUrl());
            }, function (error) {
                if (error.response.status == 422) {
                    vm.errors = error.response.data;
                    toastr.error("Please correct the input data and try again.", 'Story');
                }
            });
        },
    }
}
</script>