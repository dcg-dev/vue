<div class="block" v-if="form">
    <div class="block-content tab-content">
        <div class="row items-push">
            <div class="col-sm-offset-1 col-sm-4 form-horizontal">
                <div v-bind:class="'form-group' + (errors.title ? ' has-error' : '')">
                    <label for="form-title">Title</label>
                    <input class="form-control" id="form-title" placeholder="Story Title" type="text" v-model="form.attributes.title">
                    <span class="help-block" v-if="errors.title">
                        <div v-for="error in errors.title"><strong v-text="error"></strong></div>
                    </span>
                </div>
                <div v-bind:class="'form-group' + (errors.sub_title ? ' has-error' : '')">
                    <label for="form-sub_title">Sub Title</label>
                    <input class="form-control" id="form-sub_title" placeholder="Story Sub Title" type="text" v-model="form.attributes.sub_title">
                    <span class="help-block" v-if="errors.sub_title">
                        <div v-for="error in errors.sub_title"><strong v-text="error"></strong></div>
                    </span>
                </div>
                <div v-bind:class="'form-group' + (errors.slug ? ' has-error' : '')">
                    <label for="form-slug">Slug</label>
                    <input class="form-control" id="form-slug" placeholder="Story Slug" type="text" v-model="form.attributes.slug">
                    <span class="help-block" v-if="errors.slug">
                        <div v-for="error in errors.slug"><strong v-text="error"></strong></div>
                    </span>
                </div>
                <div v-bind:class="'form-group' + (errors.text ? ' has-error' : '')">
                    <label for="form-slug">Text</label>
                    <ckeditor :value.sync="form.attributes.text" @blur="value => form.attributes.text = value" ref="editor"></ckeditor>
                    <span class="help-block" v-if="errors.text">
                        <div v-for="error in errors.text"><strong v-text="error"></strong></div>
                    </span>
                </div>
            </div>
            <div class="col-sm-offset-1 col-sm-4 form-horizontal">
                <div v-bind:class="'form-group'+(errors.image ? ' has-error' : '')">
                    <label>Image</label>
                    <img :src="form.get('image') ? form.get('image') : '/images/noimage.jpg'" width="100%">
                        <dropzone class="dropzone push-10-t dz-clickable"
                                    id="storyImage"
                                    :url="form.getImageUrl()"
                                    v-on:vdropzone-error="imageError" 
                                    v-on:vdropzone-success="imageSuccess"
                                    v-bind:timeout="30000000"
                                    v-bind:use-font-awesome="true" 
                                    accepted-file-types="image/jpeg,image/png"
                                    v-bind:image-height="375" 
                                    v-bind:image-width="500" 
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
    <div class="block-content block-content-full bg-gray-lighter text-center">
        <button class="btn btn-lg btn-success-modern font-w500" type="submit" data-style="expand-right" v-on:click="publish($event)">Publish</button>
    </div>
</div><!-- block -->