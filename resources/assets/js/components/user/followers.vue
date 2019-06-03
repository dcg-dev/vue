<template>
    <!-- Main Content -->
    <div class="row content content-boxed">
        <!-- User Card Widgets -->
        <div class="row content-boxed" v-if="'undefined' !== typeof followers && followers.length > 0">
            <div class="col-sm-6 col-lg-3" v-for="follower in followers">
                <a class="block block-link-hover3" :href="'/user/' + follower.username">
                    <div class="block-content block-content-full text-center">
                        <div>
                            <div class="avatar-container">
                                <img class="img-avatar img-avatar96" :src="follower.avatar" :alt="follower.username">
                                <user-follow-email :user="follower" @update="(user) => follower = user"></user-follow-email>
                            </div>
                        </div>
                        <div class="h5 push-15-t push-5">{{ follower.username }}</div>
                        <button v-if="isGuest || (current_id && follower.username != current_id && !follower.followed)" v-on:click="followActions(follower.username, 'follow', $event)" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-plus text-white"></i> Follow</button>
                        <button v-if="(current_id && follower.username != current_id && follower.followed)" v-on:click="followActions(follower.username, 'unfollow', $event)" class="btn btn-xs btn-danger"><i class="fa fa-fw fa-minus text-white"></i> Unfollow</button>
                        <button v-if="current_id && follower.username == current_id" class="btn btn-xs btn-primary"> It's you</button>
                    </div>
                    <div class="block-content border-t">
                        <div class="row items-push text-center">
                            <div class="col-xs-6 border-r">
                                <div class="push-5"><i class="si si-briefcase fa-2x"></i></div>
                                <div class="h5 font-w300 text-muted">{{ follower.count_items }} Items</div>
                            </div>
                            <div class="col-xs-6">
                                <div class="push-5"><i class="si si-users fa-2x"></i></div>
                                <div class="h5 font-w300 text-muted">{{ follower.count_followers }} Followers</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row content-boxed empty-collection" v-else>
            <div class="text-center">
                <span>User doesn't have any followers</span>
            </div>
        </div>
        <!-- END User Card Widgets -->
        <!-- Disabled and Active States -->
        <div class="block-content text-center" v-if="pagination.total > pagination.to">
            <nav>
                <pagination  v-bind:pagination="pagination"
                     v-on:click.native="getFollowers(pagination.current_page)"
                     :offset="this.offset">
                </pagination>
            </nav>
        </div>
        <!-- END Disabled and Active States -->
    </div>
    <!-- END Main Content -->
</template>

<script>
export default {
    props: ['followed'],
    watch: {
        'followed': function(newValue, oldValue) {
            //if we follow/unfollow from apllication and not from this component
            if (typeof oldValue !== 'undefined') {
                this.getFollowers(this.pagination.current_page);
            }
        }
    },
    computed: {
        isGuest: function() {
            return !window.currentUser;
        }
    },
    data: function () { 
        return {
            id: null,
            current_id: null,
            errors: [],
            followers: [],
            pagination: {
                total: 0,
                per_page: 16,
                from: 1,
                to: 0,
                current_page: 1
            },
            offset: 16,
        };
    },
    mounted: function () {
        this.id = this.$el.dataset.id;
        this.current_id = window.currentUser ? window.currentUser.get('username') : false;
        this.getFollowers(this.pagination.current_page);
    },
    methods: {
        getFollowers: function (page) {
            this.errors = [];
            axios.get('/api/user/' + this.id + '/followers?page=' + page).then((response) => {
                //initialize followers data with pagination
                this.followers = response.data.data;
                this.pagination = response.data;
            }, (error) => {
                this.errors = error.response.data;
                toastr.error("Followers couldn't be retrieve.", 'Followers');
            });
        },
        followActions: function (followerUsername, type, event) {
            event.preventDefault();
            if (this.isGuest) {
                notify.guest("Please login to follow others.");
            } else {
                this.errors = [];
                axios.post('/api/user/' + followerUsername + '/' + type).then((response) => {
                    //get followers again
                    this.getFollowers(this.pagination.current_page);
                }, (error) => {
                    this.errors = error.response.data;
                    toastr.error("Error occured during Follow/Unfollow action", 'Followers');
                });
            }
        },
    },
}
</script>