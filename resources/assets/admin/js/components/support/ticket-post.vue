<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document" v-if="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" v-text="Post"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <div class="form-group">
                                <label>User</label>
                                <a v-bind:href="post.get('user').getEditUrl()" v-text="post.get('user').getFullname()"></a>
                            </div>
                        </div>
                        <div class="col-md-offset-3 col-md-6">
                            <div class="form-group">
                                <label>Created At</label>
                                <span v-text="post.get('created_at') ? post.get('created_at').format('MMMM DD, YYYY HH:mm:ss') : ''"></span>
                            </div>
                        </div>
                        <div class="col-md-offset-3 col-md-6">
                            <div class="form-group">
                                <label>Text</label>
                                <ckeditor :value.sync="post.attributes.text" @blur="value => post.attributes.text = value" ref="editor"></ckeditor>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['post'],
    }
</script>
