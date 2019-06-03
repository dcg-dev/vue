<div class="row">
    <div v-bind:class="undefined !== typeof form.slug && form.slug ? 'col-md-6' : 'col-md-offset-2 col-md-8'">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Fields</h5>
            </div>
            <div class="ibox-content">
                <div v-bind:class="'form-group'+(errors.title ? ' has-error' : '')">
                    <label>Title</label>
                    <input v-model="form.title" type="text" class="form-control">
                    <span class="help-block" v-if="errors.title">
                        <div v-for="error in errors.title"><strong v-text="error"></strong></div>
                    </span>
                </div>
                <div v-bind:class="'form-group'+(errors.sub_title ? ' has-error' : '')">
                    <label>Sub Title</label>
                    <input v-model="form.sub_title" type="text" class="form-control">
                    <span class="help-block" v-if="errors.sub_title">
                        <div v-for="error in errors.sub_title"><strong v-text="error"></strong></div>
                    </span>
                </div>
                <div v-if="undefined !== typeof form.slug && form.slug" v-bind:class="'form-group'+(errors.slug ? ' has-error' : '')">
                    <label>Slug</label>
                    <input v-model="form.slug" type="text" class="form-control">
                    <span class="help-block" v-if="errors.slug">
                        <div v-for="error in errors.slug"><strong v-text="error"></strong></div>
                    </span>
                </div>
                <div v-bind:class="'form-group'+(errors.text ? ' has-error' : '')">
                    <label>Text</label>
                    <ckeditor :value.sync="form.text" @blur="value => form.text = value" ref="editor"></ckeditor>
                    <span class="help-block" v-if="errors.text">
                        <div v-for="error in errors.text"><strong v-text="error"></strong></div>
                    </span>
                </div>
                <div v-bind:class="'form-group'+(errors.approved ? ' has-error' : '')">
                    <label>Approved</label>
                    <input v-model="form.approved" type="checkbox">
                    <span class="help-block" v-if="errors.approved">
                        <div v-for="error in errors.approved"><strong v-text="error"></strong></div>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6" v-if="undefined !== typeof form.slug && form.slug">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Image</h5>
            </div>
            <div class="ibox-content">
                <div v-bind:class="'form-group'+(errors.image ? ' has-error' : '')">
                    <img :src="form.image ? form.image : '/images/noimage.jpg'" width="100%">
                        <dropzone class="dropzone push-10-t dz-clickable"
                                    id="storyImage"
                                    :url="'/control/api/story/' + form.slug + '/image'"
                                    v-on:vdropzone-error="imageError" 
                                    v-on:vdropzone-success="imageSuccess" 
                                    v-bind:use-font-awesome="true" 
                                    accepted-file-types="image/jpeg,image/png"
                                    v-bind:image-height="375" 
                                    v-bind:image-width="500"
                                    v-bind:timeout="30000000"
                                    param-name="image"
                                    v-bind:max-file-size-in-m-b="12"
                                    v-bind:headers="headers()"
                                    v-bind:max-number-of-files="1"></dropzone>
                    <br>
                    <p class="text-gray-dark text-center">JPEG or PNG <u>1000x750px</u> Max file size <u>12 MB</u></p>
                    <span class="help-block" v-if="errors.image">
                        <div v-for="error in errors.image"><strong v-text="error"></strong></div>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-md-offset-2">
        <div class="form-group">
            <button v-on:click="submit(undefined !== typeof form.slug && form.slug, $event)" type="submit" class="btn btn-primary btn-block">
                Save
            </button>
        </div>
    </div>
    <div class="col-md-3 col-md-offset-2">
        <div class="form-group">
            <a href="/control/blog/stories" class="btn btn-info btn-block">
                Go Back
            </a>
        </div>
    </div>
</div>