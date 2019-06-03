<template>
<div class="media push-15 bg-white">
    <div class="media-left">
        <a v-bind:href="rating.get('creator').getUrl()">
            <img class="img-avatar img-avatar32" v-bind:src="rating.get('creator').get('avatar')" alt="">
        </a>
    </div>
    <div class="media-body font-s13">
        <stars :rating="rating.get('rating')"></stars> 
        <a class="font-w600" v-bind:href="rating.get('creator').getUrl()" v-text="rating.get('creator').getFullname()"></a>
        <div class="push-5" v-text="rating.get('review')"></div>
        <div class="font-s12">
            <span class="text-muted"><em v-text="rating.get('created_at').fromNow()"></em></span>
        </div>
    </div>
</div>
</template>
<script>
  export default {
    props: {
        rating: {
            type: Object,
            required: true
        }
    },
    data: function() {
        return {

        };
    },
    computed: {

    },
    methods : {

    }   
}
</script>