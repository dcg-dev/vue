<template>
    <div class="block">
        <div class="block-content block-content-full clearfix">
            <div class="text-center push-5-t">
                <div class="push-10-t">
                    <a class="btn btn-md btn-info text-left" style="width:40%;" href="#" v-on:click.prevent='share("twitter")'><i class="fa fa-twitter"></i> Tweet</a>
                    <a class="btn btn-md btn-primary focus text-right" style="width:40%;" href="#" v-on:click.prevent='share("facebook")'><i class="fa fa-facebook"></i> Share</a>
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
            }
        },
        mounted: function () {
        },
        methods: {
            share: function (type) {
                this.$parent.share(type);
            }
        }
    }
</script>