<template>
    <div v-if="form.id" class="bg-image"
         v-bind:style="'background-image:url(/images/headers/' + (form.isMaxPlan ? 'poweruser' : 'newsletter-bg') +'.jpg);'">
        <div class="block-content text-center overflow-hidden">
            <div class="push-20-t push-10 animated fadeInDown">
                <div class="avatar-container">
                    <img class="img-avatar img-avatar96 img-avatar-thumb" alt="Avatar" :src="form.avatar">
                    <user-follow-email :user="form" @update="(user) => form = user"></user-follow-email>
                </div>
            </div>
            <div class="animated fadeInUp">
                <div v-if="form.isMaxPlan">
                    <label class="label label-success-modern"> PRO+ </label>
                </div>
                <a v-text="form.username" :href="'/user/' + form.username" class="h3 font-w300 text-white"></a><br>
                <p class="push-5-t">
                    <button v-if="current && id != current && !form.followed" v-on:click="followActions('follow')"
                            class="btn btn-sm btn-white btn-outline btn-rounded js-swal-success-follow"><i
                            class="fa fa-fw fa-plus text-white"></i>Follow
                    </button>
                    <button v-if="current && id != current && form.followed" v-on:click="followActions('unfollow')"
                            class="btn btn-sm btn-white btn-outline btn-rounded js-swal-danger-follow"><i
                            class="fa fa-fw fa-minus text-white"></i>Unfollow
                    </button>
                    <button v-if="current && id == current"
                            class="btn btn-sm btn-white btn-outline btn-rounded js-swal-success-follow">It's you
                    </button>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        props: {
            form: {
                required: true
            },
            current: {
                required: true
            },
            id: {
                required: true
            }
        },
        mounted: function () {
        },
        methods: {
            followActions: function (type) {
                this.$parent.followActions(type);
            }
        }
    }
</script>

