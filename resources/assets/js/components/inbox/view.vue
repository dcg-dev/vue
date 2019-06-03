<template>
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout">
            <div class="modal-content">
                <div class="block block-themed block-transparent remove-margin-b">
                    <div class="block-header bg-primary-dark">
                        <ul class="block-options">
                            <li>
                                <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                            </li>
                        </ul>
                        <h3 class="block-title"><i class="fa fa-pencil"></i> <span
                                v-text="title + (messages.length > 1 ? ' (' + messages.length +')' : '')"></span></h3>
                    </div>
                    <div v-if="messages.length > 0" class="block-content">
                        <inbox-messages :items="messages"></inbox-messages>
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-12" :class="errors.message ? ' has-error' : ''">
                                    <label for="product-name">Message</label>
                                    <ckeditor :value.sync="formReply.message" max="5000"
                                              @blur="value => formReply.message = value" ref="editor"></ckeditor>
                                    <span class="help-block" v-if="errors.message">
                                    <div v-for="error in errors.message"><strong v-text="error"></strong></div>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-noborder btn-lg btn-danger" type="button" v-on:click.prevent="reply($event)">
                        <i class="fa fa-reply"></i> Reply
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                formReply: {},
                errors: [],
                messages: new Collection(),
                loading: false,
                title: ''
            };
        },
        props: {},
        mounted: function () {
            var _this = this;
            $('#modal-view').on('hidden.bs.modal', function (e) {
                _this.title = '';
                _this.messages = [];
                _this.formReply = {};
            });
        },
        methods: {
            reply: function (event) {
                this.errors = [];
                this.$refs.editor.instance.focusManager.blur(true);
                axios.post('/api/inbox/message', this.formReply).then((response) => {
                    this.$emit('refresh');
                    $('#modal-view').modal('hide');
                    toastr.success("Message sent successfully!", 'Inbox');
                }, (error) => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data;
                        toastr.error("An error occurred!", 'Inbox');
                    }
                });
            },
            show: function (id, title) {
                $('#modal-view').modal('show');
                this.title = title;
                this.loading = true;
                this.formReply['thread'] = id;
                axios.get('/api/inbox/thread/' + id + '/messages').then((response) => {
                    this.messages = response.data;
                    this.loading = false;
                }, (error) => {
                    this.messages = new Collection();
                    this.loading = false;
                });
            }
        },
    }
</script>