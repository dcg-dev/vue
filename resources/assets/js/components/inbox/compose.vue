<template>
<div>
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title"><i class="fa fa-pencil"></i> New Message</h3>
        </div>
        <div class="block-content block">
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-12" v-bind:class="errors.recipients ? ' has-error' : ''">
                        <label for="product-name">To</label>
                        <users v-model="form.recipients" class="form-control" style="width: 100%"></users>
                        <span class="help-block" v-if="errors.recipients">
                            <div v-for="error in errors.recipients"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12" v-bind:class="errors.subject ? ' has-error' : ''">
                        <label for="product-name">Subject</label>
                        <input type="text" v-model="form.subject" class="form-control" placeholder="">
                        <span class="help-block" v-if="errors.subject">
                            <div v-for="error in errors.subject"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12" v-bind:class="errors.message ? ' has-error' : ''">
                        <label for="product-name">Message</label>
                        <ckeditor :value.sync="form.message" max="5000" @blur="value => form.message = value" ref="editor"></ckeditor>
                        <span class="help-block" v-if="errors.message">
                            <div v-for="error in errors.message"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                </div>
            </div>
            <div class="text-center modal-body">
                <button class="btn btn-noborder btn-lg btn-success-modern" type="button" v-on:click="compose($event)">
                    Send
                </button>
            </div>
        </div>
    </div>
</div>
</template>
<script>
  export default {
    data: function() {
        return {
            form: {},
            errors: [],
            loading: false,
        };
    },
    props: {
    },
    mounted: function () {
        var _this = this;
        $('#modal-compose').on('hidden.bs.modal', function (e) {
            _this.title = '';
            _this.form = {};
        });
    },
    methods: {
        console: function (val) {
            console.log(val);
        },
        compose: function (event) {
            this.$refs.editor.instance.focusManager.blur( true );
            this.errors = [];

            axios.post('/api/inbox/thread', this.form).then((response) => {
                this.$emit('refresh');
                $('#modal-compose').modal('hide');
                toastr.success("Message sent successfully!", 'Inbox');
                location.href = '/profile/inbox';
            }, (error) => {
                if (error.response.status == 422) {
                    this.errors = error.response.data;
                } else {
                    toastr.error("An error occurred!", 'Inbox');
                }
            });
        },
    },
}
</script>