<template>
    <div class="block" v-if="form.freelance">
        <div class="block-content block-content-full text-center">
            <i class="fa fa-circle text-success"></i> I'm available for freelance work
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