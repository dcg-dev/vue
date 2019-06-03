<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title"><h5>General</h5></div>
                    <div class="ibox-content">
                        <div v-bind:class="'form-group'+(errors.firstname ? ' has-error' : '')">
                            <label>First Name*</label>
                            <input v-model="form.attributes.firstname" type="text" class="form-control">
                            <span class="help-block" v-if="errors.firstname">
                                <div v-for="error in errors.firstname"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.lastname ? ' has-error' : '')">
                            <label>Last Name*</label>
                            <input v-model="form.attributes.lastname" type="text" class="form-control">
                            <span class="help-block" v-if="errors.lastname">
                                <div v-for="error in errors.lastname"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="!createMode" v-bind:class="'form-group'+(errors.username ? ' has-error' : '')">
                            <label>Username*</label>
                            <input v-model="form.attributes.username" type="text" class="form-control">
                            <span class="help-block" v-if="errors.username">
                                <div v-for="error in errors.username"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.email ? ' has-error' : '')">
                            <label>Email*</label>
                            <input v-model="form.attributes.email" type="text" class="form-control">
                            <span class="help-block" v-if="errors.email">
                                <div v-for="error in errors.email"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.role ? ' has-error' : '')">
                            <label>Role*</label>
                            <select class="form-control" v-model="form.attributes.role">
                                <option v-bind:value="'user'" v-bind:selected="form.attributes.role == 'user'">user
                                </option>
                                <option v-bind:value="'admin'" v-bind:selected="form.attributes.role == 'admin'">admin
                                </option>
                            </select>
                            <span class="help-block" v-if="errors.role">
                                <div v-for="error in errors.role"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-if="createMode" v-bind:class="'form-group'+(errors.password ? ' has-error' : '')">
                            <label>Password*</label>
                            <input type="password" v-model="form.attributes.password" type="text" class="form-control">
                            <span class="help-block" v-if="errors.password">
                                <div v-for="error in errors.password"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.gender ? ' has-error' : '')">
                            <label>Gender</label>
                            <select class="form-control" v-model="form.attributes.gender">
                                <option v-bind:value="'male'" v-bind:selected="form.attributes.gender == 'male'">male
                                </option>
                                <option v-bind:value="'female'" v-bind:selected="form.attributes.gender == 'female'">
                                    female
                                </option>
                            </select>
                            <span class="help-block" v-if="errors.gender">
                                <div v-for="error in errors.gender"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.company ? ' has-error' : '')">
                            <label>Company</label>
                            <input v-model="form.attributes.company" type="text" class="form-control">
                            <span class="help-block" v-if="errors.company">
                                <div v-for="error in errors.company"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title"><h5>Address Details</h5></div>
                    <div class="ibox-content">
                        <div v-bind:class="'form-group'+(errors.country ? ' has-error' : '')">
                            <label>Country*</label>
                            <countries v-model="form.attributes.country"></countries>
                            <span class="help-block" v-if="errors.country">
                                <div v-for="error in errors.country"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.state ? ' has-error' : '')">
                            <label>State/Canton</label>
                            <input v-model="form.attributes.state" type="text" class="form-control">
                            <span class="help-block" v-if="errors.state">
                                <div v-for="error in errors.state"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.city ? ' has-error' : '')">
                            <label>City</label>
                            <input v-model="form.attributes.city" type="text" class="form-control">
                            <span class="help-block" v-if="errors.city">
                                <div v-for="error in errors.city"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.address_1 ? ' has-error' : '')">
                            <label>Street Name</label>
                            <input v-model="form.attributes.address_1" type="text" class="form-control">
                            <span class="help-block" v-if="errors.address_1">
                                <div v-for="error in errors.address_1"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.address_2 ? ' has-error' : '')">
                            <label>Street Name 2</label>
                            <input v-model="form.attributes.address_2" type="text" class="form-control">
                            <span class="help-block" v-if="errors.address_2">
                                <div v-for="error in errors.address_2"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title"><h5>Billim Details</h5></div>
                    <div class="ibox-content">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td>Paypal email:</td>
                                <td>
                                    <strong v-if="form.attributes.paypal_email"
                                            v-text="form.attributes.paypal_email"></strong>
                                    <strong class="text-danger" v-if="!form.attributes.paypal_email">
                                        The user has not yet setup his PayPal
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Stripe ID:</td>
                                <td>
                                    <strong v-if="form.attributes.stripe_id"
                                            v-text="form.attributes.stripe_id"></strong>
                                    <strong class="text-danger" v-if="!form.attributes.stripe_id">
                                        The user has not yet setup his Stripe
                                    </strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title"><h5>Profile</h5></div>
                    <div class="ibox-content">
                        <label v-if="!createMode">Avatar</label>
                        <div v-if="!createMode && form.attributes.username"
                             v-bind:class="'form-group'+(errors.avatar ? ' has-error' : '')">
                            <div class="row m-b-lg">
                                <div class="col-md-4 col-md-offset-4">
                                    <img :src="form.attributes.avatar ? form.attributes.avatar : '/images/noimage.jpg'"
                                         width="100%">
                                </div>
                            </div>
                            <dropzone class="dropzone push-10-t dz-clickable"
                                      id="userAvatar"
                                      :url="'/control/api/user/' + form.attributes.username + '/avatar'"
                                      v-on:vdropzone-error="avatarError"
                                      v-on:vdropzone-success="avatarSuccess"
                                      v-bind:use-font-awesome="true"
                                      accepted-file-types="image/jpeg,image/png"
                                      v-bind:image-height="375"
                                      v-bind:image-width="500"
                                      v-bind:timeout="30000000"
                                      param-name="avatar"
                                      v-bind:max-file-size-in-m-b="12"
                                      v-bind:headers="headers()"
                                      v-bind:max-number-of-files="1"></dropzone>
                            <br>
                            <p class="text-gray-dark text-center">JPEG or PNG <u>1000x750px</u> Max file size <u>12
                                    MB</u></p>
                            <span class="help-block" v-if="errors.avatar">
                                <div v-for="error in errors.avatar"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.biography ? ' has-error' : '')">
                            <label>Biography</label>
                            <textarea v-model="form.attributes.biography" class="form-control"></textarea>
                            <span class="help-block" v-if="errors.biography">
                                <div v-for="error in errors.biography"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.facebook_link ? ' has-error' : '')">
                            <label>Facebook</label>
                            <input v-model="form.attributes.facebook_link" type="text" class="form-control">
                            <span class="help-block" v-if="errors.facebook_link">
                                <div v-for="error in errors.facebook_link"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.youtube_link ? ' has-error' : '')">
                            <label>Youtube</label>
                            <input v-model="form.attributes.youtube_link" type="text" class="form-control">
                            <span class="help-block" v-if="errors.youtube_link">
                                <div v-for="error in errors.youtube_link"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.twitter_link ? ' has-error' : '')">
                            <label>Twitter</label>
                            <input v-model="form.attributes.twitter_link" type="text" class="form-control">
                            <span class="help-block" v-if="errors.twitter_link">
                                <div v-for="error in errors.twitter_link"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.soundcloud_link ? ' has-error' : '')">
                            <label>Soundcloud</label>
                            <input v-model="form.attributes.soundcloud_link" type="text" class="form-control">
                            <span class="help-block" v-if="errors.soundcloud_link">
                                <div v-for="error in errors.soundcloud_link"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.show_skills ? ' has-error' : '')">
                            <label>Show Skills</label>
                            <input v-model="form.attributes.show_skills" type="checkbox">
                            <span class="help-block" v-if="errors.show_skills">
                                <div v-for="error in errors.show_skills"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.skills ? ' has-error' : '')">
                            <label>Skills</label>
                            <select v-if="!createMode" class="form-control" size="8" multiple
                                    v-model="form.attributes.skillIds">
                                <option v-for="skill in allowedSkills" v-bind:value="skill.id"
                                        v-bind:selected="_.includes(form.attributes.skillIds, skill.id)">
                                    @{{ skill.name }}
                                </option>
                            </select>
                            <span class="help-block" v-if="errors.skills">
                                <div v-for="error in errors.skills"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.show_country ? ' has-error' : '')">
                            <label>Show Country</label>
                            <input v-model="form.attributes.show_country" type="checkbox">
                            <span class="help-block" v-if="errors.show_country">
                                <div v-for="error in errors.show_country"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.freelance ? ' has-error' : '')">
                            <label>Available for Freelancing</label>
                            <input v-model="form.attributes.freelance" type="checkbox">
                            <span class="help-block" v-if="errors.freelance">
                                <div v-for="error in errors.freelance"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.activated ? ' has-error' : '')">
                            <label>Activated</label>
                            <input v-model="form.attributes.activated" type="checkbox">
                            <span class="help-block" v-if="errors.activated">
                                <div v-for="error in errors.activated"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title"><h5>Privacy</h5></div>
                    <div class="ibox-content">
                        <div v-bind:class="'form-group'+(errors.show_status ? ' has-error' : '')">
                            <label>Online Status</label>
                            <input v-model="form.attributes.show_status" type="checkbox">
                            <span class="help-block" v-if="errors.show_status">
                                <div v-for="error in errors.show_status"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.notification_release ? ' has-error' : '')">
                            <label>Notifications Release</label>
                            <input v-model="form.attributes.notification_release" type="checkbox">
                            <span class="help-block" v-if="errors.notification_release">
                                <div v-for="error in errors.notification_release"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.notification_sale ? ' has-error' : '')">
                            <label>Notifications Sale</label>
                            <input v-model="form.attributes.notification_sale" type="checkbox">
                            <span class="help-block" v-if="errors.notification_sale">
                                <div v-for="error in errors.notification_sale"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.notification_inbox ? ' has-error' : '')">
                            <label>Notifications Inbox</label>
                            <input v-model="form.attributes.notification_inbox" type="checkbox">
                            <span class="help-block" v-if="errors.notification_inbox">
                                <div v-for="error in errors.notification_inbox"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.notification_comments ? ' has-error' : '')">
                            <label>Notifications Comments</label>
                            <input v-model="form.attributes.notification_comments" type="checkbox">
                            <span class="help-block" v-if="errors.notification_comments">
                                <div v-for="error in errors.notification_comments"><strong
                                            v-text="error"></strong></div>
                            </span>
                        </div>
                        <div v-bind:class="'form-group'+(errors.notification_reviews ? ' has-error' : '')">
                            <label>Notifications Reviews</label>
                            <input v-model="form.attributes.notification_reviews" type="checkbox">
                            <span class="help-block" v-if="errors.notification_reviews">
                                <div v-for="error in errors.notification_reviews"><strong v-text="error"></strong></div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center m-b-lg">
    <a href="/control/user/list" class="btn btn-white">
        <i class="fa fa-forward"></i> Go Back
    </a>
    <button v-on:click="submit(createMode, $event)" type="submit" class="btn btn-success">
        Save changes
    </button>
    <button v-on:click="ban" type="submit" class="btn" :class="form.attributes.banned_at ? 'btn-warning' : 'btn-danger'" v-if="!createMode">
        @{{ form.attributes.banned_at ? 'Unban' : 'Ban' }} user
    </button>
</div>