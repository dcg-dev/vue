@extends('layouts.main')
@section('title', $item->name)
@section('subtitle', 'Sell your work worldwide')
@section('content')
    @include('profile.topbar')
    <div class="content content-boxed" id="item-edit" data-id="{{$item->slug}}">
        <div class="block" v-if="form.attributes">
            <form-alert v-if="successShow"
                        message="Your item was submitted successfully for review." style="position: fixed"></form-alert>
            @include('item.partials.form')
            <div class="block" v-if="formats && !formats.isEmpty()">
                <div class="block-header bg-gray-lighter">
                    <h3>File formats</h3>
                    <p class="text-gray-dark">Choose all file formats included</p>
                </div>
                <div class="content content-boxed push-100-l push-100-r">
                    <div class="row">
                        <div class="col-sm-3 col-lg-3" v-for="format in formats.getData()">
                            <label class="css-input css-checkbox css-checkbox-primary">
                                <input type="checkbox" v-bind:checked="form.hasFormat(format.get('id')) ? true : false"
                                       v-on:change="formatChange(format.get('id'), $event)"><span></span>
                                <span v-text="format.get('name')"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <h3>Upload Image Cover</h3>
                    <p class="text-gray-dark">High quality image files only</p>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
                            <div v-bind:class="'form-group'+(errors.image ? ' has-error' : '')">
                                <img v-if="form.hasImage()" v-bind:src="form.get('image')" width="100%">
                                <dropzone class="dropzone push-10-t dz-clickable"
                                          id="itemThumbnail"
                                          url="{{route('item.edit.thumbnail', ['item'=> $item->slug])}}"
                                          v-on:vdropzone-error="thumbnailError"
                                          v-on:vdropzone-success="thumbnailSuccess"
                                          v-bind:use-font-awesome="true"
                                          v-bind:thumbnail-height="375"
                                          v-bind:timeout="30000000"
                                          v-bind:thumbnail-width="500"
                                          param-name="image"
                                          v-bind:max-file-size-in-m-b="12"
                                          v-bind:headers="headers()"
                                          v-bind:max-number-of-files="1"></dropzone>
                                <br>
                                <p class="text-gray-dark text-center">JPEG or PNG <u>1000x750px</u> Max file size <u>12
                                        MB</u></p>
                                <span class="help-block" v-if="errors.image">
                                <div v-for="error in errors.image">
                                    <strong v-text="error"></strong>
                                </div>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <h3>Audio Demo File</h3>
                    <p class="text-gray-dark">Uploading instrumentals? <br>Watermark and protect your preview file.</p>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
                            <div v-bind:class="'form-group'+(errors.demo ? ' has-error' : '')">
                                <player v-if="form.get('demo')" id="demo-player"
                                        v-bind:sound="form.get('demo')"></player>
                                <dropzone class="dropzone push-10-t dz-clickable"
                                          id="itemDemo"
                                          url="{{route('item.edit.demo', ['item'=> $item->slug])}}"
                                          v-on:vdropzone-error="demoError"
                                          v-on:vdropzone-success="demoSuccess"
                                          v-bind:use-font-awesome="true"
                                          v-bind:timeout="30000000"
                                          param-name="demo"
                                          v-bind:max-file-size-in-m-b="24"
                                          v-bind:headers="headers()"
                                          v-bind:max-number-of-files="1"></dropzone>
                                <span class="help-block" v-if="errors.demo">
                                <div v-for="error in errors.demo">
                                    <strong v-text="error"></strong>
                                </div>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <h3>Product File</h3>
                    <p class="text-gray-dark">ZIP files only</p>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
                            <div v-bind:class="'form-group'+(errors.file ? ' has-error' : '')">
                                <a href="{{route('item.download.product', ['item'=>$item->slug])}}"
                                   v-if="form.get('file')">
                                    <i class="fa fa-file-zip-o fa-2x"></i> Product File
                                </a>
                                <dropzone class="dropzone push-10-t dz-clickable"
                                          id="itemProduct"
                                          url="{{route('item.edit.product', ['item'=> $item->slug])}}"
                                          v-on:vdropzone-error="productError"
                                          v-on:vdropzone-success="productSuccess"
                                          v-bind:use-font-awesome="true"
                                          param-name="product"
                                          v-bind:timeout="30000000"
                                          v-bind:max-file-size-in-m-b="400"
                                          v-bind:headers="headers()"
                                          v-bind:max-number-of-files="1"></dropzone>
                                <span class="help-block" v-if="errors.file">
                                <div v-for="error in errors.file">
                                    <strong v-text="error"></strong>
                                </div>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <h3>Price &amp; Options*</h3>
                    <p class="text-gray-dark">*if available in category</p>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-3 col-sm-offset-3 push-20 push-10-t">
                                <div v-bind:class="'form-group'+(errors.price ? ' has-error' : '')">
                                    <div class="form-material form-material-primary">
                                        <input class="form-control" type="number" v-model="form.attributes.price"
                                               min="0" max="9999" v-on:change="save">
                                        <label>Price in USD ($) </label>
                                        <span class="help-block" v-if="errors.price">
                                        <div v-for="error in errors.price"><strong v-text="error"></strong></div>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" v-if="!licenses.isEmpty()">
                            <div class="col-sm-12 col-sm-offset-3">
                                <label for="Options">License (only available for certain categories) </label> <br>
                                <div v-for="license in licenses.getData()">
                                    <label class="css-input css-checkbox css-checkbox-primary">
                                        <input type="checkbox"
                                               v-bind:checked="form.hasLicense(license.get('id')) ? true : false"
                                               v-on:change="licenseChange(license.get('id'), $event)">
                                        <span></span>
                                        <span v-text="license.get('name')"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 col-sm-offset-3  push-20 push-30-t">
                                <label for="Options">Other options </label> <br>
                                <label class="css-input css-checkbox css-checkbox-primary">
                                    <input type="checkbox" v-model="form.attributes.loopable"
                                           v-on:change="save"><span></span> Loopable
                                </label> <br>
                                <label class="css-input css-checkbox css-checkbox-primary">
                                    <input type="checkbox" v-model="form.attributes.includes_stems"
                                           v-on:change="save"><span></span> Includes Stems
                                </label> <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="block-header bg-gray-lighter">
                        <h3>Free Item?</h3>
                        <p class="text-gray-dark">Offer item for free to attract more followers.<br>More followers equal
                            more people that can see your items.</p>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-12 col-sm-offset-3">
                                    <label for="Options">Offer this item for free?</label> <br>
                                    <label class="css-input css-checkbox css-checkbox-primary">
                                        <input type="checkbox" v-bind:checked="form.isFree() ? true : false" value=1
                                               v-on:change="setFree"><span></span> Yes, offer this item for free.
                                    </label> <br>
                                    <label :class="'css-input  css-checkbox css-checkbox-primary' + (currentUser.canUsePro() ? '' : ' css-input-disabled')">
                                        <input :disabled="!currentUser.canUsePro()"
                                               v-bind:checked="form.attributes.need_follow" type="checkbox"
                                               v-on:change="needFollow"><span></span> Users that want to download this
                                        free item need to follow me (auto-follow). <span
                                                class="label label-default">PRO</span>
                                    </label> <br>
                                    {{--<label class="css-input css-input-disabled  css-checkbox css-checkbox-primary">--}}
                                    {{--<input disabled="" type="checkbox"><span></span> Offer item for free but let users still set a price.  <span class="label label-default">PRO</span>--}}
                                    {{--</label>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <h3>Submit</h3>
                            <p class="text-gray-dark">Ready to rock? Awesome.</p>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="form-group push-30">
                                    <div class="col-xs-12">
                                        <button class="h1 btn btn-lg btn-primary js-notify"
                                                v-on:click="publish($event)">Submit for review
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
