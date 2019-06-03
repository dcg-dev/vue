<template>
    <div class="row">
        <div v-bind:class="itemClass" v-for="item in collection.getData()">
            <div class="block bg-white">
                <a class="block block-rounded block-link-hover6" v-bind:href="item.getUrl()">
                    <img class="img-responsive" v-bind:src="item.get('image')" alt="">
                    <div class="block-content block-content-full remove-padding push-20-t">
                        <h3 class="h4 push-10 font-w300" v-text="item.get('title')"></h3>
                        <p class="text-gray-dark push-10-b" v-text="item.getShortText()"></p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {};
        },
        props: {
            collection: {
                type: Object,
                required: true
            },
            itemClass: {
                type: String,
                default: 'col-sm-4 push-20'
            },
        },
        computed: {}
    }
</script>