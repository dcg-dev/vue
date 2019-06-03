<template>
    <div class="bg-modern-dark2">
        <section class="content content-full content-boxed overflow-hidden">
            <div class="text-left">
                <h2 class="h2 text-white-op animated fadeInDown font-w300" data-toggle="appear" data-class="animated fadeInDown" v-text="item.get('name')"></h2>
                <h6 class="h6 text-white-op animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
                    by <a v-bind:href="item.get('creator').getUrl()" class="text-white-op" v-text="item.get('creator').getFullname()"></a>
                </h6>
            </div>
        </section>
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
        }
    }
</script>