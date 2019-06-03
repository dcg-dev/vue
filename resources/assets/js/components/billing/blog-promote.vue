<template>
    <div class="row push-20-t push-20">
        <div v-if="can">
            <h3 class="font-w300 animated fadeInUp push-20-l"><i class="si si-rocket"></i> Extra Promotions</h3>
            <h6 class="font-w400 animated fadeInUp push-20-l push-20 text-muted">
                Promote your brand and grow even more</h6>
            <div class="col-sm-6 col-lg-4 animated fadeInUp" data-toggle="appear" data-offset="50"
                 data-class="animated fadeInUp">
                <!-- Developer Plan -->
                <a class="block block-bordered block-link-hover3 text-center" href="javascript:void(0)">
                    <div class="block-header bg-flat">
                        <h3 class="font-w300 text-white">Blog Post<br>
                            <badge class="badge badge-default">PRO</badge>
                        </h3>
                        <h6 class="text-white font-w400">only</h6>
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter">
                        <div class="h1 font-w300 push-10">${{ price }}</div>
                        <div class="h5 font-w300 text-muted">per Blog Post</div>
                    </div>
                    <div class="block-content">
                        <table class="table table-borderless table-condensed">
                            <tbody>
                            <tr>
                                <td><i class="fa fa-check text-success-modern"></i> Your Bio and Avatar</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-check text-success-modern"></i> Links to your profile</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-check text-success-modern"></i> Gain much more attention</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-check text-success-modern"></i> Get more followers</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-check text-success-modern"></i> More longterm exposure</td>
                            </tr>
                            <tr class="push-20-t push-20">
                                <td><span class="text-muted small">Your article must be meet certain quality requirements. Please read them <a
                                        v-bind:href="route"><u><b>here</b></u></a> before buying this promotion.</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="block-content block-content-mini block-content-full bg-gray-lighter text-white">
                        <span class="btn btn-success-modern btn-lg" v-on:click="modalBlogBook">Book</span>
                        <span v-if="user && user.get('availableStories')" class="btn btn-primary btn-lg"
                              v-on:click="modalBlogCreate">Create</span>
                    </div>
                </a>
                <!-- END Developer Plan -->
            </div>
            <stories-pay id="modal-blog" v-on:book="booked" :secret="secret"
                         :story_price="price"></stories-pay>
            <stories-create id="modal-create"></stories-create>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        props: {
            price: {
                required: true
            },
            secret: {
                type: String,
                required: true
            },
            route: {
                type: String,
                required: true
            },
            user: {
                required: true
            },
        },
        computed: {
            can: function () {
                return currentUser.canUsePro();
            }    
        },
        mounted: function () {
        },
        methods: {
            modalBlogBook: function () {
                this.$parent.modalBlogBook();
            },
            modalBlogCreate: function () {
                this.$parent.modalBlogCreate();
            },
            booked: function () {
                this.$parent.booked();
            }
        }
    }
</script>