<div class="block-header bg-gray-lighter">
    <h3>Information</h3>
    <p class="text-gray-dark">State the main informations</p>
</div>
<div class="block-content block-content-full">
    <div class="push-30-t push-30">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
                <div v-bind:class="'form-group'+(errors.categoriesIds ? ' has-error' : '')">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="product-name">Category</label>
                            <categories v-model="form.attributes.categoriesIds" class="form-control" multiple v-on:input="save"></categories>
                            <span class="help-block" v-if="errors.categoriesIds">
                                <div v-for="error in errors.categoriesIds"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                    </div>
                </div>
                <div v-bind:class="'form-group'+(errors.name ? ' has-error' : '')">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-material form-material-primary">
                                <input class="js-maxlength form-control" type="text" maxlength="50" data-always-show="true" placeholder="Set a short title..." v-model="form.attributes.name" @change="save">
                                <label for="product-name">Item Name</label>
                                <span class="help-block" v-if="errors.name">
                                    <div v-for="error in errors.name"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-bind:class="'form-group'+(errors.description ? ' has-error' : '')">
                    <label>Description</label>
                    <ckeditor :value="form.attributes.description" max="5000" @blur="ckeditorUpdate" ref="editor"></ckeditor>
                    <span class="help-block" v-if="errors.description">
                        <div v-for="error in errors.description"><strong v-text="error"></strong></div>
                    </span>
                </div>
                <div v-bind:class="'form-group'+(errors.tagsIds ? ' has-error' : '')">
                    <label>Tags (max. 5)</label>
                    <tags v-model="form.attributes.tagsIds" class="form-control" multiple v-on:input="save"></tags>
                    <span class="help-block" v-if="errors.tagsIds">
                        <div v-for="error in errors.tagsIds"><strong v-text="error"></strong></div>
                    </span>
                </div>
                <div v-bind:class="'form-group push-50'+(errors.accepeted ? ' has-error' : '')" v-if="scenario=='new'">
                    <label class="css-input css-checkbox css-checkbox-primary">
                        <input v-model="form.attributes.accepeted" type="checkbox"><span></span> I agree to terms &amp; conditions.
                    </label>
                    <span class="help-block" v-if="errors.accepeted">
                        <div v-for="error in errors.accepeted"><strong v-text="error"></strong></div>
                    </span>
                </div>
                <div class="form-group push-30 text-center" v-if="scenario=='new'">
                    <div class="col-xs-12">
                        <button class="h3 btn btn-lg btn-success-modern js-notify ladda-button" data-style="zoom-in" v-on:click="submit($event)">Upload files</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>