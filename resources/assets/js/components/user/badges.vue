<template>
    <div class="block" v-if="form.facebook_link || form.youtube_link || form.twitter_link || form.soundcloud_link">
        <div class="block-content block-content-full text-center">
            <a v-if="form.facebook_link" target="_blank" v-bind:href="form.facebook_link"><i class="fa fa-facebook text-muted round round-md hollow"></i> &nbsp;</a>
            <a v-if="form.twitter_link" target="_blank" v-bind:href="form.twitter_link"><i class="round round-md hollow fa fa-twitter text-muted"></i> &nbsp;</a>
            <a v-if="form.youtube_link" target="_blank" v-bind:href="form.youtube_link"><i class="fa fa-youtube text-muted round round-md hollow"></i> &nbsp;</a>
            <a v-if="form.soundcloud_link" target="_blank" v-bind:href="form.soundcloud_link"><i class="fa fa-soundcloud text-muted round round-md hollow"></i></a>
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
            }
        },
        mounted: function () {
        },
        methods: {
        }
    }
</script>