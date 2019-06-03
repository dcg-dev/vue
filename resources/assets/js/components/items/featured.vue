<template>
<section class="content content-full content-boxed">
    <!-- Section Content -->
    <div class="row push-50 push-20-t">
        <div v-bind:class="itemClass" v-for="item in collection.getData()">
            <a class="block block-themed bg-image" :style="{'background-image': 'url(' + item.get('image') + ')', 'background-position': 'center'}" v-bind:href="item.getUrl()">
                <div class="block-header text-right push-100">
                    <stars :rating="item.get('rating', 0)"></stars>
                </div>
                <div class="block-content bg-black-op">
                    <h2 class="font-w700 h4 push-10 text-white"  v-text="item.get('name')"></h2>
                    <p class="text-white-op">{{ 'by ' + item.get('creator').getFullname() }} |
                        <span v-if="item.isFree()">Free</span>
                        <span v-if="!item.isFree()">
                            $<span v-text="item.getPrice()"></span>
                        </span>
                    </p>
                </div>
            </a>
        </div>
    </div>
    <!-- END Section Content -->
</section>

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
        child: false,
        itemClass: {
            type: String,
            default: 'col-sm-6 col-md-3'
        },
    },
    methods: {
    }
}
</script>