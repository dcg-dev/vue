<template>   
    <div class="bg-gray-lighter" v-if="user">
        <section class="content content-full content-boxed">
            <!-- Section Content -->
            <div class="push-20-t push-20 text-center">
                <h3 class="h4 push-20 animated fadeIn" data-toggle="appear">Can't find what you were looking for?</h3>
                <a class="btn btn-rounded btn-noborder btn-lg btn-success-modern animated bounceIn" data-toggle="appear" data-class="animated bounceIn" v-bind:href="route">Open Support Ticket</a>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        props: {
            user: {
                required: true
            },
            route: {
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