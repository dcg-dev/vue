<template>
    <span class="follow-email" v-if="user.followed && (current && user.id != current.get('id'))">
        <button class="btn btn-success-modern btn-rounded btn-xs" data-placement="top"
                title="Notify me if this user has a new item." @click.prevent="followed('follow')" v-if="!user.iFollowMail">
            <i class="fa fa-bell-o"></i>
        </button>
        <button class="btn btn-danger btn-rounded btn-xs" data-placement="top"
                title="Unsubscribe me from receiving notifications to mail from this user."
                @click.prevent="followed('unfollow')"
                v-if="user.iFollowMail">
            <i class="fa fa-bell-o"></i>
        </button>
    </span>
</template>

<script>
    export default {
        props: {
            user: {
                required: true
            }
        },
        computed: {
            current: function () {
                return currentUser;
            }
        },
        mounted: function () {
            console.log(this.user);
        },
        methods: {
            followed: function (type) {
                axios.post('/api/user/' + this.user.username + '/' + type + '/email').then((response) => {
                    this.$emit('update', response.data);
                    this.$forceUpdate();
                }, (error) => {
                    swal("Users", "Error occured during Follow/Unfollow action", 'error');
                });
            }
        }
    }
</script>