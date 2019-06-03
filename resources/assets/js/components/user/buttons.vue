<template>
    <div class="block" v-if="guest || (current && id != current)">
        <div class="block-content block-content-full text-center">
            <button v-if="isGuest || !form.followed" v-on:click="followActions('follow')"
                    class="btn btn-sm btn-success-modern btn-outline btn-rounded js-swal-success-follow font-w500">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Follow&nbsp;&nbsp;&nbsp;&nbsp;
            </button>
            <button v-if="form.followed" v-on:click="followActions('unfollow')"
                    class="btn btn-sm btn-danger btn-outline btn-rounded js-swal-danger-follow font-w500"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unfollow&nbsp;&nbsp;&nbsp;&nbsp;
            </button>
            <button class="btn btn-sm btn-default btn-outline btn-rounded font-w500"
                    @click.prevent="sendMessage">
                <i class="si si-envelope"></i> Send Message
            </button>
            <inbox-compose-modal v-if="!isGuest" ref="compose" :to="form.id"></inbox-compose-modal>
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
            },
            guest: {
                type: Boolean,
                required: true
            }
        },
        mounted: function () {
        },
        methods: {
            followActions: function (type) {
                this.$parent.followActions(type);
            },
            sendMessage: function () {
                if (!window.currentUser) {
                    notify.guest("Please login to send the message.");
                } else {
                    $($refs.compose.$el).modal('show')
                }
            }
        }
    }
</script>