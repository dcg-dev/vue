<template>
    <div class="block">
        <div class="block-content block-content-full clearfix">
            <div class="pull-right">
                <a class="font-w600" v-bind:href="item.get('creator').getUrl()">
                    <div class="avatar-container">
                        <img class="img-avatar" v-bind:src="item.get('creator').getAvatar()" alt="">
                        <user-follow-email :user="item.get('creator').attributes"
                                           @update="(user) => item.get('creator').setAttributes(user)"
                                           style="margin-bottom: -5px;"></user-follow-email>
                    </div>
                </a>
            </div>
            <div class="pull-left push-5-t">
                <div class="push-10">
                    By <a class="font-w600" v-bind:href="item.get('creator').getUrl()"
                          v-text="item.get('creator').getFullname()"></a><br>
                </div>
                <div class="push-10-t" v-if="user && user.get('id') != item.get('creator_id')">
                    <a class="btn btn-sm btn-default" v-if="!item.get('creator').iFollow()"
                       v-on:click.prevent="item.get('creator').follow()"><i class="fa fa-plus"></i> Follow</a>
                    <a class="btn btn-sm btn-primary" v-if="item.get('creator').iFollow()"
                       v-on:click.prevent="item.get('creator').follow()"><i class="fa fa-minus"></i> Unfollow</a>
                    <a class="btn btn-sm btn-default" @click.prevent="$($refs.compose.$el).modal('show')"><i
                            class="fa fa-envelope"></i></a>
                    <inbox-compose-modal v-if="!isGuest" ref="compose"
                                         :to="item.get('creator_id')"></inbox-compose-modal>
                </div>
                <div class="push-10-t" v-if="!user">
                    <a class="btn btn-sm btn-default" v-on:click.prevent="guestMessage"><i class="fa fa-plus"></i>
                        Follow</a>
                    <a class="btn btn-sm btn-default" href="#" v-on:click.prevent="guestMessage"><i
                            class="fa fa-envelope"></i></a>
                </div>
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
            item: {
                required: true
            },
            user: {
                required: true
            }
        },
        mounted: function () {
        },
        methods: {
            guestMessage: function () {
                this.$parent.guestMessage();
            },
            $: function (el) {
                return $(el);
            }
        }
    }
</script>