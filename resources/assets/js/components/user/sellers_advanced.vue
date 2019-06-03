<template>
<div class="row">
    <div v-bind:class="itemClass" v-for="user in collection.getData()">
        <a class="block block-link-hover3" v-bind:href="user.getUrl()">
            <div class="block-content block-content-full text-center">
                <div>
                    <div class="avatar-container">
                        <img class="img-avatar img-avatar96" v-bind:src="user.getAvatar()" alt="">
                        <user-follow-email :user="user.attributes" @update="(attributes) => user.setAttributes(attributes)"></user-follow-email>
                    </div>
                </div>
                <div class="h5 push-15-t push-5" v-text="user.getFullname()"></div>
                <div>
                    <a href="#" class="btn btn-xs btn-primary" v-if="!currentUser || (!user.iFollow() && currentUser && user.get('id') != currentUser.get('id'))" v-on:click.prevent="follow(user)"><i class="fa fa-fw fa-plus text-white"></i> Follow</a>
                    <a href="#" class="btn btn-xs btn-danger" v-if="currentUser && user.iFollow() && user.get('id') != currentUser.get('id')" v-on:click.prevent="user.follow()"><i class="fa fa-fw fa-minus text-white"></i> Unfollow</a>
                    <button v-if="currentUser && user.get('id') == currentUser.get('id')" href="#" class="btn btn-xs btn-white" disabled="true">It's you</button>
                </div>
            </div>
            <div class="block-content border-t">
                <div class="row items-push text-center">
                    <div class="col-xs-6 border-r">
                        <div class="push-5"><i class="si si-briefcase fa-2x"></i></div>
                        <div class="h5 font-w300 text-muted" v-text="user.get('count_items', 0)+' Items'"></div>
                    </div>
                    <div class="col-xs-6">
                        <div class="push-5"><i class="si si-users fa-2x"></i></div>
                        <div class="h5 font-w300 text-muted" v-text="user.get('count_followers', 0)+' Follower'"></div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
</template>
<script>
  export default {
    props: {
        collection: {
            type: Object,
            required: true
        },
        itemClass: {
            type: String,
            default: 'col-sm-6 col-lg-2'
        },
    },
    computed: {
        'currentUser': function() {
            return window.currentUser;
        }
    },
    methods: {
        follow: function (user) {
            if (!this.currentUser) {
                notify.guest("Please login to follow others.");
            } else {
                user.follow();
            }
        }
    }
}
</script>