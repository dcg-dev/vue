<template>
<div class="row">
    <div v-bind:class="itemClass" v-for="item in collection.getData()">
        <a class="block block-rounded block-link-hover3" v-bind:href="item.getUrl()">
            <div class="block-content block-content-full text-center clearfix">
                <div class="pull-center">
                    <img class="img-avatar" v-bind:src="item.getAvatar()" alt="">
                </div>
                <div class="pull-center push-10-t">
                    <div class="font-w600 push-5" v-text="item.getFullname()"></div>
                    <div class="text-muted" v-text="item.get('count_followers', 0)+' Follower'"></div>
                </div>
            </div>
        </a>
    </div>
</div>
</template>
<script>
  export default {
    data: function() {
        return {
        };
    },
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
    
    }
}
</script>