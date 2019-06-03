<template>   
    <div class="bg-img overflow-hidden push" v-bind:style="'background-image: url(' + route + ');'">
        <div class="">
            <div class="content">
                <div class="block block-transparent block-themed text-center">
                    <div class="block-content">
                        <h1 class="h2 font-w300 text-white-op" v-text="title"></h1>
                        <h2 class="h5 font-w400 text-white-op" v-text="subtitle"></h2>
                    </div>
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
            route: {
                type: String,
                required: true
            },
            title: {
                type: String,
                required: true
            },
            subtitle: {
                type: String,
                required: true
            },
        },
        mounted: function () {
        },
        methods: {
        }
    }
</script>