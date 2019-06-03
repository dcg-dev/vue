<template>
    <div>
        <div class="block-content" v-if="'undefined' !== typeof form.followers && form.followers.length > 0">
            <ul class="nav-users push">
                <li v-for="follower in form.followers">
                    <a v-bind:href="'/user/' + follower.username">
                        <img class="img-avatar" v-bind:alt="follower.username" v-bind:src="follower.avatar">
                        <i class="fa fa-circle text-success" v-if="follower.online"></i>
                        <span v-text="follower.username"></span>
                        <div class="font-w400 text-muted"><small v-text="follower.count_followers == 1 ? '1 Follower' : follower.count_followers+' Followers'"></small></div>
                    </a>
                </li>
            </ul>
            <div class="text-center push">
                <small><a v-bind:href="route">Load More..</a></small>
            </div>
        </div>
        <div class="block-content empty-collection" v-else>
            <div class="text-center push">
                <small>User doesn't have any followers</small>
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
            route: {
                type: String,
                required: true
            }
        },
        mounted: function () {
        },
        methods: {
        }
    }
</script>