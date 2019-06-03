<template>
    <a href="#" v-if="author" class="btn btn-lg btn-success-modern btn-block push-30 push-10-t h4 font-w400"  type="button" v-on:click.prevent="modal()">New Collection</a>
</template>

<script>
    export default {
        data() {
            return {}
        },
        props: {
            author: {
                type: Boolean,
                required: true
            }
        },
        mounted: function () {
        },
        methods: {
            modal: function () {
                this.$parent.modal();
            }
        }
    }
</script>
