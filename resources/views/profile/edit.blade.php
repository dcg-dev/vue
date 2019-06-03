@extends('layouts.main')
@section('title', 'Profile')
@section('subtitle', 'Edit your public profile')
@section('content')
@include('profile.topbar')
<div class="content content-boxed" id="profile-edit">
    <!-- Avatar -->
    <div class="block-content bg-primary-op text-center overflow-hidden">
        <div class="animated fadeInDown">
            <img class="img-avatar img-avatar96 img-avatar-thumb push-10" alt="Avatar" :src="form.avatar">
        </div><!-- animated fadeInDown -->
        <div class="push-20 animated fadeInUp">
            <a :href="'/user/' + form.username" class="h5 font-w600 text-white push-5"> <i class="fa fa-link fa-1x"></i> <span v-text="form.username"></span></a>
        </div><!-- animated fadeInUp -->
        <div>
            <label class="btn btn-primary btn-sm btn-square push-5" for="upload-avatar">
                <input @change="previewThumbnail" id="upload-avatar" type="file">
                Upload Avatar
            </label>
            <span class="help-block" v-if="errors.avatar">
                <div v-for="error in errors.avatar"><strong v-text="error"></strong></div>
            </span>
        </div>
    </div><!-- block-content -->
    <!-- END Avatar -->

    <!-- user profile -->
    <div class="block">
        <div class="block-content tab-content">
            <!-- Personal Tab -->
            <div class="tab-pane fade active in" id="tab-profile-personal">
                <div class="row items-push">
                    <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label>Username</label>
                                <div class="form-control-static font-w700" v-text="form.username"></div>
                            </div>
                        </div>
                        <div v-bind:class="'form-group'+(errors.biography ? ' has-error' : '')">
                            <div class="col-xs-12">
                                <label for="profile-bio">Bio</label>
                                <textarea class="form-control input-lg" id="profile-bio" rows="15" placeholder="Enter a few details about yourself.." v-model="form.biography"></textarea>
                                <span class="help-block" v-if="errors.biography">
                                    <div v-for="error in errors.biography"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                        <div v-bind:class="'form-group'+(errors.facebook_link ? ' has-error' : '')">
                            <label class="col-xs-12" for="example-disabled-input">Facebook <label class="label label-default font-w300">PRO</label></label>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="Your facebook link" :disabled="!currentUser.canUsePro()" type="text" v-model="form.facebook_link">
                                <span class="help-block" v-if="errors.facebook_link">
                                    <div v-for="error in errors.facebook_link"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                        <div v-bind:class="'form-group'+(errors.youtube_link ? ' has-error' : '')">
                            <label class="col-xs-12" for="example-disabled-input">Youtube <label class="label label-default font-w300">PRO</label></label>
                            <div class="col-sm-9">
                                <input class="form-control"  placeholder="Your youtube link" :disabled="!currentUser.canUsePro()" type="text" v-model="form.youtube_link">
                                <span class="help-block" v-if="errors.youtube_link">
                                    <div v-for="error in errors.youtube_link"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                        <div v-bind:class="'form-group'+(errors.twitter_link ? ' has-error' : '')">
                            <label class="col-xs-12" for="example-disabled-input">Twitter <label class="label label-default font-w300">PRO</label></label>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="Your twitter link" :disabled="!currentUser.canUsePro()" type="text" v-model="form.twitter_link">
                                <span class="help-block" v-if="errors.twitter_link">
                                    <div v-for="error in errors.twitter_link"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                        <div v-bind:class="'form-group'+(errors.soundcloud_link ? ' has-error' : '')">
                            <label class="col-xs-12" for="example-disabled-input">Soundcloud <label class="label label-default font-w300">PRO</label></label>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="Your soundcloud link" :disabled="!currentUser.canUsePro()" type="text" v-model="form.soundcloud_link">
                                <span class="help-block" v-if="errors.soundcloud_link">
                                    <div v-for="error in errors.soundcloud_link"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                        <div v-bind:class="'form-group'+(errors.show_skills ? ' has-error' : '')">
                            <label class="col-xs-12">Show Skills</label>
                            <div class="col-xs-12">
                                <label class="css-input css-radio css-radio-primary push-10-r">
                                    <input type="radio" v-model="form.show_skills" :value="true"><span></span> Yes
                                </label>
                                <label class="css-input css-radio css-radio-primary">
                                    <input type="radio" v-model="form.show_skills" :value="false"><span></span> No
                                </label>
                                <span class="help-block" v-if="errors.show_skills">
                                    <div v-for="error in errors.show_skills"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                        <div v-bind:class="'form-group'+(errors.skills ? ' has-error' : '')" v-show="form.show_skills">
                            <div class="col-xs-12">
                                <label for="profile-skills">Skills</label>
                                <select class="form-control" size="8" multiple v-model="form.skills">
                                    <option v-for="skill in allowedSkills" v-bind:value="skill.id"
                                            v-bind:selected="_.includes(form.skillIds, skill.id)"
                                            v-text="skill.name">
                                    </option>
                                </select>
                                <span class="help-block" v-if="errors.skills">
                                    <div v-for="error in errors.skills"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                        <div v-bind:class="'form-group'+(errors.show_country ? ' has-error' : '')">
                            <label class="col-xs-12">Show Country</label>
                            <div class="col-xs-12">
                                <label class="css-input css-radio css-radio-primary push-10-r">
                                    <input type="radio" v-model="form.show_country" :value="true"><span></span> Yes
                                </label>
                                <label class="css-input css-radio css-radio-primary">
                                    <input type="radio" v-model="form.show_country" :value="false"><span></span> No
                                </label>
                                <span class="help-block" v-if="errors.show_country">
                                    <div v-for="error in errors.show_country"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                        <div v-bind:class="'form-group'+(errors.freelance ? ' has-error' : '')">
                            <label class="col-xs-12">Available for Freelancing</label>
                            <div class="col-xs-12">
                                <label class="css-input css-radio css-radio-primary push-10-r">
                                    <input type="radio" v-model="form.freelance" :value="true"><span></span> Yes
                                </label>
                                <label class="css-input css-radio css-radio-primary">
                                    <input type="radio" v-model="form.freelance" :value="false"><span></span> No
                                </label>
                                <span class="help-block" v-if="errors.freelance">
                                    <div v-for="error in errors.freelance"><strong v-text="error"></strong></div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Personal Tab -->
        </div>
        <div class="block-content block-content-full bg-gray-lighter text-center">
            <button class="btn btn-lg btn-success-modern font-w500" type="submit" v-on:click="saveChanges($event)">Save Changes</button>
        </div>
    </div><!-- block -->
    <!-- user profile -->
</div><!-- content content-boxed -->
@endsection