<div class="row">
    <div v-bind:class="form.attributes.slug ? 'col-md-6' : 'col-md-offset-2 col-md-8'">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title"><h5>General</h5></div>
                    <div class="ibox-content">
                        <div v-bind:class="'form-group'+(errors.name ? ' has-error' : '')">
                            <label>Name*</label>
                            <input v-model="form.attributes.name" type="text" class="form-control">
                            <span class="help-block" v-if="errors.name">
                                <div v-for="error in errors.name"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="!createMode" v-bind:class="'form-group'+(errors.slug ? ' has-error' : '')">
                            <label>Slug*</label>
                            <input v-model="form.attributes.slug" type="text" class="form-control">
                            <span class="help-block" v-if="errors.slug">
                                <div v-for="error in errors.slug"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.creator_id ? ' has-error' : '')">
                            <label>Creator*</label>
                            <users v-model="form.attributes.creator_id" :user="form.attributes.creator"
                                   class="form-control"></users>
                            <span class="help-block" v-if="errors.creator_id">
                                <div v-for="error in errors.creator_id"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="createMode" v-bind:class="'form-group'+(errors.categoriesIds ? ' has-error' : '')">
                            <label>Category*</label>
                            <categories v-model="form.attributes.categoriesIds" class="form-control"
                                        multiple></categories>
                            <span class="help-block" v-if="errors.categoriesIds">
                                <div v-for="error in errors.categoriesIds"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="createMode" v-bind:class="'form-group'+(errors.tagsIds ? ' has-error' : '')">
                            <label>Tags (max. 5)</label>
                            <tags v-model="form.attributes.tagsIds" class="form-control" multiple></tags>
                            <span class="help-block" v-if="errors.tagsIds">
                                <div v-for="error in errors.tagsIds"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="form.attributes.id && !createMode"
                             v-bind:class="'form-group'+(errors.categoriesIds ? ' has-error' : '')">
                            <label>Category*</label>
                            <categories v-model="form.attributes.categoriesIds" class="form-control"
                                        multiple></categories>
                            <span class="help-block" v-if="errors.categoriesIds">
                                <div v-for="error in errors.categoriesIds"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="form.attributes.id && !createMode"
                             v-bind:class="'form-group'+(errors.tagsIds ? ' has-error' : '')">
                            <label>Tags (max. 5)</label>
                            <tags v-model="form.attributes.tagsIds" class="form-control" multiple></tags>
                            <span class="help-block" v-if="errors.tagsIds">
                                <div v-for="error in errors.tagsIds"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div class="block" v-if="formats && !formats.isEmpty()">
                            <div class="block-header bg-gray-lighter">
                                <h3>File formats</h3>
                                <p class="text-gray-dark">Choose all file formats included</p>
                            </div>
                            <div class="content content-boxed push-100-l push-100-r">
                                <div class="row">
                                    <div class="col-sm-3 col-lg-3" v-for="format in formats.getData()">
                                        <label class="css-input css-checkbox css-checkbox-primary">
                                            <input type="checkbox"
                                                   v-bind:checked="form.hasFormat(format.get('id')) ? true : false"
                                                   v-on:change="formatChange(format.get('id'), $event)"><span></span>
                                            <span v-text="format.get('name')"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-bind:class="'form-group'+(errors.description ? ' has-error' : '')">
                            <label>Description</label>
                            <ckeditor :value.sync="form.attributes.description"
                                      @blur="value => form.attributes.description = value" ref="editor"></ckeditor>
                            <span class="help-block" v-if="errors.description">
                                <div v-for="error in errors.description"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="!createMode" v-bind:class="'form-group'+(errors.status ? ' has-error' : '')">
                            <label>Status*</label>
                            <select class="form-control" v-model="form.attributes.status">
                                <option v-bind:value="0" v-bind:selected="form.attributes.status == 0">Draft</option>
                                <option v-bind:value="1" v-bind:selected="form.attributes.status == 1">Awaiting review
                                </option>
                                <option v-bind:value="2" v-bind:selected="form.attributes.status == 2">Approved</option>
                                <option v-bind:value="3" v-bind:selected="form.attributes.status == 3">Declined</option>
                            </select>
                            <span class="help-block" v-if="errors.status">
                                <div v-for="error in errors.status"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.created_at ? ' has-error' : '')"
                             v-if="form.attributes.id && form.attributes.status == 2 && !createMode">
                            <label>Date of approved</label>
                            <datepicker v-model="form.attributes.approved_at"
                                        :input-class="'form-control'"
                                        :placeholder="'Choose date'"></datepicker>
                            <span class="help-block" v-if="errors.approved_at">
                                <div v-for="error in errors.approved_at"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="!createMode && form.attributes.status == 3"
                             v-bind:class="'form-group'+(errors.decline_reason ? ' has-error' : '')">
                            <label>Decline Reason</label>
                            <input v-model="form.attributes.decline_reason" type="text" class="form-control">
                            <span class="help-block" v-if="errors.decline_reason">
                                <div v-for="error in errors.decline_reason"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="!createMode" v-bind:class="'form-group'+(errors.price ? ' has-error' : '')">
                            <label>Price*</label>
                            <input v-model="form.attributes.price" type="text" class="form-control">
                            <span class="help-block" v-if="errors.price">
                                <div v-for="error in errors.price"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="!createMode" v-bind:class="'form-group'+(errors.licensesIds ? ' has-error' : '')">
                            <label>License*</label>
                            <div v-for="license in licenses.getData()">
                                <label class="css-input css-checkbox css-checkbox-primary">
                                    <input type="checkbox"
                                           v-bind:checked="form.hasLicense(license.get('id')) ? true : false"
                                           v-on:change="licenseChange(license.get('id'), $event)">
                                    <span></span>
                                    <span v-text="license.get('name')"></span>
                                </label>
                            </div>
                            <span class="help-block" v-if="errors.licensesIds">
                                <div v-for="error in errors.licensesIds"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div class="form-group" v-if="form.attributes.id && !createMode">
                            <label>Set free</label>
                            <input type="checkbox" v-bind:checked="form.isFree() ? true : false" value=1
                                   v-on:change="setFree">
                        </div>
                        <div v-if="!createMode" v-bind:class="'form-group'+(errors.need_follow ? ' has-error' : '')">
                            <label>Users that want to download this free item need to follow me (auto-follow).</label>
                            <input v-model="form.attributes.need_follow" type="checkbox">
                            <span class="help-block" v-if="errors.need_follow">
                                <div v-for="error in errors.need_follow"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="!createMode" v-bind:class="'form-group'+(errors.loopable ? ' has-error' : '')">
                            <label>Loopable</label>
                            <input v-model="form.attributes.loopable" type="checkbox">
                            <span class="help-block" v-if="errors.loopable">
                                <div v-for="error in errors.loopable"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="!createMode" v-bind:class="'form-group'+(errors.includes_stems ? ' has-error' : '')">
                            <label>Includes Stems</label>
                            <input v-model="form.attributes.includes_stems" type="checkbox">
                            <span class="help-block" v-if="errors.includes_stems">
                                <div v-for="error in errors.includes_stems"><strong v-text="error"></strong></div>
                            </span>
                        </div>

                        <div class="form-group" v-bind:class="errors.includes_stems ? ' has-error' : ''">
                            <label>Featured item (manual)</label>
                            <input v-model="form.attributes.featured" type="checkbox">
                            <span class="help-block" v-if="errors.featured">
                                <div v-for="error in errors.featured"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6" v-if="!createMode && form.attributes.slug">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title"><h5>Files</h5></div>
                    <div class="ibox-content">
                        <div v-bind:class="'form-group'+(errors.thumbnail ? ' has-error' : '')">
                            <label>Image</label>
                            <div class="row m-b-lg">
                                <div class="col-md-8 col-md-offset-2">
                                    <img :src="form.attributes.image ? form.attributes.image : '/images/noimage.jpg'"
                                         width="100%">
                                </div>
                            </div>
                            <input class="form-control" v-model="form.attributes.files.image" type="text">
                            <dropzone class="dropzone push-10-t dz-clickable"
                                      id="itemThumbnail"
                                      v-bind:url="'/control/api/item/' + form.attributes.slug + '/thumbnail'"
                                      v-on:vdropzone-error="thumbnailError"
                                      v-on:vdropzone-success="thumbnailSuccess"
                                      v-bind:use-font-awesome="true"
                                      v-bind:image-height="375"
                                      v-bind:image-width="500"
                                      v-bind:timeout="30000000"
                                      param-name="image"
                                      v-bind:max-file-size-in-m-b="12"
                                      v-bind:headers="headers()"
                                      v-bind:max-number-of-files="1"></dropzone>
                            <br>
                            <p class="text-gray-dark text-center">JPEG or PNG <u>1000x750px</u> Max file size <u>12
                                    MB</u></p>
                            <span class="help-block" v-if="errors.thumbnail">
                                <div v-for="error in errors.thumbnail"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.demo ? ' has-error' : '')">
                            <label>Demo File</label>
                            <br>
                            <player v-if="form.attributes.demo" id="demo-player"
                                    v-bind:sound="form.attributes.demo"></player>
                            <br>
                            <input class="form-control" v-model="form.attributes.files.demo" type="text">
                            <dropzone class="dropzone push-10-t dz-clickable"
                                      id="itemDemo"
                                      v-bind:url="'/control/api/item/' + form.attributes.slug + '/demo'"
                                      v-on:vdropzone-error="demoError"
                                      v-on:vdropzone-success="demoSuccess"
                                      v-bind:timeout="30000000"
                                      v-bind:use-font-awesome="true"
                                      param-name="demo"
                                      v-bind:max-file-size-in-m-b="24"
                                      v-bind:headers="headers()"
                                      v-bind:max-number-of-files="1"></dropzone>
                            <span class="help-block" v-if="errors.demo">
                                <div v-for="error in errors.demo"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.product ? ' has-error' : '')">
                            <label>Product File</label>
                            <br>
                            <a v-bind:href="'/item/' + form.attributes.slug + '/download/product'"
                               v-if="form.attributes.file">
                                <i class="fa fa-file-zip-o fa-2x"></i> Product File
                            </a>
                            <br>
                            <input class="form-control" v-model="form.attributes.files.file" type="text">
                            <dropzone class="dropzone push-10-t dz-clickable"
                                      id="itemProduct"
                                      v-bind:url="'/control/api/item/' + form.attributes.slug + '/product'"
                                      v-on:vdropzone-error="productError"
                                      v-on:vdropzone-success="productSuccess"
                                      v-bind:use-font-awesome="true"
                                      v-bind:timeout="30000000"
                                      param-name="product"
                                      v-bind:max-file-size-in-m-b="400"
                                      v-bind:headers="headers()"
                                      v-bind:max-number-of-files="1"></dropzone>
                            <span class="help-block" v-if="errors.product">
                                <div v-for="error in errors.product">
                                    <strong v-text="error"></strong>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-md-offset-2">
        <div class="form-group">
            <button v-on:click="save(createMode, $event)" type="submit" class="btn btn-primary btn-block">
                Save
            </button>
        </div>
    </div>
    <div class="col-md-3 col-md-offset-2">
        <div class="form-group">
            <a href="/control/item/list" class="btn btn-info btn-block">
                Go Back
            </a>
        </div>
    </div>
</div>