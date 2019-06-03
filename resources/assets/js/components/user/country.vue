<template>
    <div class="block" v-if="form.country && form.show_country">
        <div class="block-content block-content-full text-center">
            <i class="glyphicon glyphicon-map-marker text-muted"></i>
            <span v-text="' ' + (form.city ? form.city + ', ' : ' ') + form.country"></span>
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