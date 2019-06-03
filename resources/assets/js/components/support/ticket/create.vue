<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-popout">
            <div class="modal-content">
                <div class="block block-themed block-transparent block-rounded remove-margin-b">
                    <div class="block-header bg-white">
                        <ul class="block-options">
                            <li>
                                <button data-dismiss="modal" type="button"><i class="si si-close fa-2x text-gray"></i>
                                </button>
                            </li>
                        </ul>
                        <h3 class="font-w600">Create Support Ticket</h3>
                    </div>
                    <div class="block-content">
                        <div class="row" v-if="ticket">
                            <div class="col-sm-12 push-20">
                                <label>Subject</label>
                                <div v-bind:class="'form-group' + (errors.subject ? ' has-error' : '')">
                                    <input class="form-control" v-model="ticket.attributes.subject"
                                           placeholder="Support Ticket Subject" type="text">
                                    <span class="help-block" v-if="errors.subject">
                                    <div v-for="error in errors.subject"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                            <div class="col-sm-12 push-20">
                                <label>Description</label>
                                <div v-bind:class="'form-group' + (errors.description ? ' has-error' : '')">
                                    <ckeditor :value.sync="ticket.attributes.description"
                                              @blur="value => ticket.attributes.description = value" max="5000"
                                              ref="editor"></ckeditor>
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
                                <button class="btn btn-lg btn-default font-w400" type="button" data-dismiss="modal">
                                    Cancel
                                </button>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button class="btn btn-lg btn-success-modern push-right font-w400" type="button"
                                        data-style="expand-right" v-on:click="submit($event)">Create Support Ticket
                                </button>
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
                ticket: new SupportTicket(),
                errors: [],
                button: null,
            };
        },
        methods: {
            clearForm: function () {
                this.ticket = new SupportTicket();
            },
            toggle: function (event) {
                $(this.$el).modal('toggle');
            },
            submit: function (event) {
                this.errors = [];
                var vm = this;
                this.$refs.editor.instance.focusManager.blur( true );
                this.ticket.create(function (newSupportTicket) {
                    vm.clearForm();
                    vm.errors = [];
                    toastr.success("Support Ticket has been created successfully.", 'SupportTicket');
                    vm.toggle();
                    vm.$parent.getTickets();
                }, function (error) {
                    if (error.response.status == 422) {
                        vm.errors = error.response.data;
                        toastr.error("Please correct the input data and try again.", 'SupportTicket');
                    }
                });
            },
        }
    }
</script>