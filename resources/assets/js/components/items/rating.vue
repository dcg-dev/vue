<template>
    <a href="#ecom-product-reviews" data-toggle="tab">
        <div class="block bg-white">
            <div class="block-content bg-white text-center">
                <stars class="h2 text-warning push-10" :rating="item.get('rating', 0)"></stars>
                <p>
                    <strong v-text="item.get('rating', 0)"></strong>/5 out of <strong v-text="item.get('count_rating', 0)"></strong> Ratings
                </p>
            </div>
        </div>    
    </a>
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